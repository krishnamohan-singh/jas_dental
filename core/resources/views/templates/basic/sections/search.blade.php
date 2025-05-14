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

@php
    $searchContent = getContent('search.content',true);
    $locations     = \App\Models\Location::orderBy('id', 'DESC')->whereHas('doctors')->get(['id','name']);
    //$departments   = \App\Models\Department::orderBy('id', 'DESC')->whereHas('doctors')->get(['id','name']);
    //$doctors       = \App\Models\Doctor::orderBy('id', 'DESC')->get(['id','name']);
@endphp
<section class="appoint-section ptb-80 bg-overlay-white bg_img" data-background="{{ frontendImage('search', @$searchContent->data_values->image,'1600x640') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center mrb-50">
                <div class="appoint-content">
                    <h3 class="title">{{ __($searchContent->data_values->heading) }}</h3>
                    <p style="font-weight:500;font-size:20px">{{ __($searchContent->data_values->subheading) }}</p>
                </div>
            </div>

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
                                <input id="localAreaId" type="hidden" name="location" placeholder="Local Area">
                                <input id="localArea" type="text" name="area" placeholder="Local Area" autocomplete="off">
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
<section class="section1">
        <div class="container">
            <div class="items">
            <div class="image">
                <img src="{{asset('assets/images/new/cityscape 1.png')}}" alt="image not found">
            </div>
            <div class="text">
                <span style="font-size: 28px; font-weight: 600">50+</span><br>
                <span style="font-size: 16px; font-weight: 500">Areas</span>
            </div>
            </div>

            <div class="items">
            <div class="image">
                <img src="{{asset('assets/images/new/cityscape 1 (1).png')}}" alt="image not found">
            </div>
            <div class="text">
                <span style="font-size: 28px; font-weight: 600">25+</span><br>
                <span style="font-size: 16px; font-weight: 500">Clinics</span>
            </div>
            </div>

            <div class="items">
            <div class="image">
                <img src="{{asset('assets/images/new/cityscape 1 (2).png')}}" alt="image not found">
            </div>
            <div class="text">
                <span style="font-size: 28px; font-weight: 600">100+</span><br>
                <span style="font-size: 16px; font-weight: 500">Dentists</span>
            </div>
            </div>

            <div class="items">
            <div class="image">
                <img src="{{asset('assets/images/new/cityscape 1 (3).png')}}" alt="image not found">
            </div>
            <div class="text">
                <span style="font-size: 28px; font-weight: 600">5000+</span><br>
                <span style="font-size: 16px; font-weight: 500">Patients</span>
            </div>
            </div>
        </div>
        </section>
</section>
  
  