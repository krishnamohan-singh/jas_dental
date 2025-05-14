@php
    $departmentContent = getContent('department.content',true);
@endphp



<!-- choose-section start -->
<section class="choose-section ptb-60">
    <div class="container" style="max-width: none;">
        <div class="row justify-content-center align-items-center ml-b-30">
            <div class="col-lg-12 mrb-30">
                <div class="choose-left-content">
                    <style>
                        section {
                            background: linear-gradient(to bottom, #f8fdff, #dff3ff);
                            
                        }
                        .banner1 {
                            padding: 50px 20px;
                            text-align: center;
                            position: relative;
                            background: url('/assets/img/ist.png') no-repeat right bottom;
                            background-size: 40%;
                            display: block !important;
                        }
                        .banner1-content {
                            position: relative;
                            z-index: 2;
                        }
                        .banner1 h2 {
                            font-weight: bold;
                        }
                        .banner1 h2 span {
                            color: #3ea9ff;
                        }
                        .service-card {
                            text-align: center;
                            padding: 20px;
                            opacity: 0; /* Start hidden */
                            transform: translateY(-30px); /* Start slightly above */
                        }
                        .btn-primary {
                            background-color: #3ea9ff;
                            border: none;
                        }
                        .btn-primary:hover {
                            background-color: #007bff;
                        }
                    
                        /* Animation */
                        @keyframes slideDown {
                            0% {
                                opacity: 0;
                                transform: translateY(-30px);
                            }
                            100% {
                                opacity: 1;
                                transform: translateY(0);
                            }
                        }
                    
                        /* Responsive Adjustments */
                        @media (max-width: 992px) {
                            .banner1 {
                                background-size: 60%;
                            }
                            .service-card {
                                padding: 15px;
                            }
                        }
                    
                        @media (max-width: 768px) {
                            .banner1 {
                                background: none; /* Remove background image */
                            }
                            .banner1 h2 {
                                font-size: 22px;
                            }
                            .service-card {
                                padding: 10px;
                            }
                            .service-card img {
                                width: 50px; /* Reduce image size */
                                height: 50px;
                            }
                        }
                    
                        @media (max-width: 576px) {
                            .banner1 h2 {
                                font-size: 18px;
                            }
                            .service-card {
                                text-align: center;
                                width: 100%;
                                padding: 8px;
                            }
                            .service-card img {
                                width: 40px;
                                height: 40px;
                            }
                            .btn-primary {
                                font-size: 14px;
                                padding: 6px 12px;
                            }
                        }
                        
                    </style>
                    <section>
                        <section class="banner1">
                            @php echo trans($departmentContent->data_values->body) @endphp
                        </section>
                    </section> 
                </div>
            </div>
            
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const serviceCards = document.querySelectorAll(".service-card");
    
            serviceCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.animation = "slideDown 0.6s ease forwards";
                }, index * 200); // Delays each item for a smooth cascading effect
            });
        });
    </script>
</section>
<!-- choose-section end -->
