<!-- Portfolio Start -->
<section id="portfolio" class="portfolio section-space-padding <?php if( isset($_SESSION['is_user_login']) && $_SESSION['is_user_login']){ echo "padding-top-zero"; }?>">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="section-title">
                    <h2>our Portfolio.</h2>
                   
                </div>
            </div>
        </div>

        <div class="row">
            <ul class="portfolio">
                <li class="filter" data-filter="all">all</li>
                <li class="filter" data-filter=".apps">bus</li>
                <li class="filter" data-filter=".mockups">seat</li>
            </ul>
        </div>

        <div class="portfolio-inner">
            <div class="row">


                <div class="col-md-4 col-sm-6 col-xs-12 mix mockups">
                    <div class="item">
                        <a href="assets/Front_end_assets/images/portfolio/img1.jpg" class="portfolio-popup" title="Project Title">
                            <img src="assets/Front_end_assets/images/portfolio/img1.jpg" alt="">
                        </a>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12 mix mockups">
                    <div class="item">
                        <a href="assets/Front_end_assets/images/portfolio/img2.jpg" class="portfolio-popup" title="Project Title">
                            <img src="assets/Front_end_assets/images/portfolio/img2.jpg" alt="">
                        </a>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12 mix mockups">
                    <div class="item">
                        <a href="assets/Front_end_assets/images/portfolio/img3.jpg" class="portfolio-popup" title="Project Title">
                            <img src="assets/Front_end_assets/images/portfolio/img3.jpg" alt="">
                        </a>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12 mix apps wordpress">
                    <div class="item">
                        <a href="assets/Front_end_assets/images/portfolio/img5.jpg" class="portfolio-popup" title="Project Title">
                            <img src="assets/Front_end_assets/images/portfolio/img5.jpg" alt="">
                        </a>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12 mix wordpress apps">
                    <div class="item">
                        <a href="assets/Front_end_assets/images/portfolio/img6.jpg" class="portfolio-popup" title="Project Title">
                            <img src="assets/Front_end_assets/images/portfolio/img6.jpg" alt="">
                        </a>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12 mix apps wordpress" title="Project Title">
                    <div class="item">
                        <a href="assets/Front_end_assets/images/portfolio/img8.jpg" class="portfolio-popup">
                            <img src="assets/Front_end_assets/images/portfolio/img8.jpg" alt="">
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="text-center margin-top-50">
        <a class="button button-style button-style-dark button-style-icon fa fa-long-arrow-right smoth-scroll" href="#contact">Let's Discuss</a>
    </div>

</section>
