@extends($activeTemplate . 'layouts.frontend')

<style type="text/css">
     
    /*the container must be positioned relative:*/
    .autocomplete {
      position: relative;
    }
     
    .autocomplete-items {
      position: absolute;
      border: 1px solid #d4d4d4;
      border-bottom: none;
      border-top: none;
      z-index: 99;
      /*position the autocomplete items to be the same width as the container:*/
      top: 100%;
      left: 0;
      right: 0;
    }
    
    .autocomplete-items div {
      padding: 10px;
      cursor: pointer;
      background-color: #fff; 
      border-bottom: 1px solid #d4d4d4; 
    }
    
    /*when hovering an item:*/
    .autocomplete-items div:hover {
      background-color: #e9e9e9; 
    }
    
    /*when navigating through the items using the arrow keys:*/
    .autocomplete-active {
      background-color: DodgerBlue !important; 
      color: #ffffff; 
    }
</style>


@section('content')
    <section class="appoint-section ptb-80">
        <div class="container">
          <!--Booking Search area-->
            <div class="booking-search-area">
                <div class="row justify-content-center">
                    <div class="col-lg-12 text-center">
                        <form class="appoint-form" action="{{ route('doctors.search') }}" method="get" >
                                @csrf
                            <div class="row justify-content-center">
                                <div class="col-lg-4 text-center">
                                    <div class="autocomplete">
                                        <input  type="text" name="Bengaluru" value="Bengaluru" readonly="true" placeholder="Location">
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center">
                                    <div class="autocomplete">
                                        <input id="localAreaId" type="hidden" name="location" value={{$locationId}} placeholder="Local Area">
                                        <input id="localArea" type="text" name="area" value="{{$locationName}}" placeholder="Local Area" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-1 text-center">
                                    <div class="mrt-10">
                                        <button type="submit" class="search-btn cmn-btn"><i class="las la-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--  Doctors Card Satrted -->
            <div class="row justify-content-center ml-b-30">
                @forelse($doctors as $doctor)
                    <div class="col-lg-3 col-md-6 col-sm-6 mrb-30">
                      <a href="{{ route('doctors.booking', trim(base64_encode($doctor->id.'-'.time()), '=')) }}">
                        <div class="booking-item">
                            <div class="booking-thumb">
                                <img src="{{ getImage(getFilePath('doctorProfile') . '/' . @$doctor->image, getFileSize('doctorProfile')) }}"
                                    alt="@lang('booking')">
                               
                                @if ($doctor->featured)
                                    <span class="fav-btn"><i class="fas fa-medal"></i></span>
                                @endif
                            </div>
                            <div class="booking-content">
                                <h5 class="title">{{ __($doctor->name) }} <i class="fas fa-check-circle text-success"></i>
                                </h5>
                                <!-- <p>{{ strLimit(__($doctor->qualification), 50) }}</p> -->
                                <ul class="booking-list">
                                    <li><i class="fas fa-street-view"></i>
                                        <a
                                            href="{{ route('doctors.locations', $doctor->location->id) }}">{{ __($doctor->location->name) }}</a>
                                    </li>
                                    <li><i class="fas fa-phone"></i> {{ __($doctor->mobile) }}</li>
                                </ul>
                                <div class="booking-btn">
                                    <a href="{{ route('doctors.booking', trim(base64_encode($doctor->id.'-'.time()), '=')) }}"
                                        class="cmn-btn w-100 text-center">@lang('Book Now')</a>
                                </div>
                            </div>
                        </div>
                      </a>
                    </div>
                @empty
                    <div class="col-lg-12 col-md-12 col-sm-12 mrb-30">
                        <div class="booking-item text-center">
                            <h3 class="title mt-2">{{ __($emptyMessage) }}</h3>
                            <div class="booking-btn mt-4 mb-2">
                                <a href="javascript:window.history.back();" class="cmn-btn">@lang('Go Back')</a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            {{ $doctors->links() }}
        </div>


        <script>
            function autocomplete(inp, arr, areasIds) {
              /*the autocomplete function takes two arguments,
              the text field element and an array of possible autocompleted values:*/
              var currentFocus;
              /*execute a function when someone writes in the text field:*/
              inp.addEventListener("input", function(e) {
                  var a, b, i, val = this.value, k=0;
                  /*close any already open lists of autocompleted values*/
                  closeAllLists();
                  if (!val) { return false;}
                  currentFocus = -1;
                  /*create a DIV element that will contain the items (values):*/
                  a = document.createElement("DIV");
                  a.setAttribute("id", this.id + "autocomplete-list");
                  a.setAttribute("class", "autocomplete-items");
                  /*append the DIV element as a child of the autocomplete container:*/
                  this.parentNode.appendChild(a);
                  /*for each item in the array...*/
                  for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                      /*create a DIV element for each matching element:*/
                      b = document.createElement("DIV");
                      /*make the matching letters bold:*/
                      b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                      b.innerHTML += arr[i].substr(val.length);
                      /*insert a input field that will hold the current array item's value:*/
                      b.innerHTML += "<input type='hidden' value='" + arr[i] + "' data-area-id='" + areasIds[i] + "'>";
                      /*execute a function when someone clicks on the item value (DIV element):*/
                      b.addEventListener("click", function(e) {
                          /*insert the value for the autocomplete text field:*/
                          inp.value = this.getElementsByTagName("input")[0].value;
                         //inp.setAttribute('data-area-id', this.getElementsByTagName("input")[0].getAttribute('data-area-id')) 
                         document.getElementById("localAreaId").value = this.getElementsByTagName("input")[0].getAttribute('data-area-id');
                          //console.log(this.getElementsByTagName("input")[0].getAttribute('data-area-id'));
                          closeAllLists();
                      });
                      a.appendChild(b);
                      if(++k == 5){
                        break;
                      }
                    }
                  }
              });
              /*execute a function presses a key on the keyboard:*/
              inp.addEventListener("keydown", function(e) {
                  var x = document.getElementById(this.id + "autocomplete-list");
                  if (x) x = x.getElementsByTagName("div");
                  if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                  } else if (e.keyCode == 8) { //backspace
                    document.getElementById("localAreaId").value = 0;
                  } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                  } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                      /*and simulate a click on the "active" item:*/
                      if (x) x[currentFocus].click();
                    }
                  }
              });
              function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
              }
              function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                  x[i].classList.remove("autocomplete-active");
                }
              }
              function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                  if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                  }
                }
              }
              /*execute a function when someone clicks in the document:*/
              document.addEventListener("click", function (e) {
                  closeAllLists(e.target);
              });
            }
            
            var areas = [];
            var areasIds = [];
            @foreach ($locations as $item)
                areas.push("{{ $item->name }}");      
                areasIds.push("{{ $item->id }}");      
            @endforeach
            
            autocomplete(document.getElementById("localArea"), areas, areasIds);
      </script>


    </section>

    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
