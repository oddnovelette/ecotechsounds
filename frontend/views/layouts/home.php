<?php

/* @var $this \yii\web\View */

use frontend\widgets\Blog\LastPostsWidget;

/* @var $content string */

?>
<?php $this->beginContent('@frontend/views/layouts/main.php') ?>
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="http://uploads.ecotechsounds.local/cache/img/ny.jpg" alt="New York" width="1200" height="700">
            <div class="carousel-caption">
                <h3>New York</h3>
                <p>The atmosphere in New York is lorem ipsum.</p>
            </div>
        </div>

        <div class="item">
            <img src="http://uploads.ecotechsounds.local/cache/img/chicago.jpg" alt="Chicago" width="1200" height="700">
            <div class="carousel-caption">
                <h3>Chicago</h3>
                <p>Thank you, Chicago - A night we won't forget.</p>
            </div>
        </div>

        <div class="item">
            <img src="http://uploads.ecotechsounds.local/cache/img/la.jpg" alt="Los Angeles" width="1200" height="700">
            <div class="carousel-caption">
                <h3>LA</h3>
                <p>Even though the traffic was a mess, we had the best time playing at Venice Beach!</p>
            </div>
        </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<!-- Container (The Band Section) -->
<div id="band" class="container text-center">
    <h3>THE BAND</h3>
    <p><em>We love music!</em></p>
    <p>Шооаьщц цоцащцшштташц ттцыы We have created a fictional band website. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    <br>

</div>

<!-- Container (TOUR Section) -->
<div id="tour">
    <div class="container bg-1">
        <h2 class="widget-heading">LATEST FROM MAGAZINE:</h2>
        <div class="row">
        <?= LastPostsWidget::widget([
            'limit' => 9,
        ]) ?>
        </div>

        </div>
    </div>

<!-- Container (Contact Section) -->
<div id="contact" class="container">
    <h2 class="widget-heading">CONTACT US:</h2>

    <div class="row">
        <div class="col-md-4">
            <p>Fan? Drop a note.</p>
            <p><span class="glyphicon glyphicon-map-marker"></span>Chicago, US</p>
            <p><span class="glyphicon glyphicon-phone"></span>Phone: +00 1515151515</p>
            <p><span class="glyphicon glyphicon-envelope"></span>Email: mail@mail.com</p>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-sm-6 form-group">
                    <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
                </div>
                <div class="col-sm-6 form-group">
                    <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
                </div>
            </div>
            <textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5"></textarea>
            <br>
            <div class="row">
                <div class="col-md-12 form-group">
                    <button class="btn btn-primary pull-right" type="submit">Send</button>
                </div>
            </div>
        </div>
    </div>
    <br>
    <h3 class="text-center">From The Blog</h3>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Mike</a></li>
        <li><a data-toggle="tab" href="#menu1">Chandler</a></li>
        <li><a data-toggle="tab" href="#menu2">Peter</a></li>
    </ul>

    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <h2>Mike Ross, Manager</h2>
            <p>Man, we've been on the road for some time now. Looking forward to lorem ipsum.</p>
        </div>
        <div id="menu1" class="tab-pane fade">
            <h2>Chandler Bing, Guitarist</h2>
            <p>Always a pleasure people! Hope you enjoyed it as much as I did. Could I BE.. any more pleased?</p>
        </div>
        <div id="menu2" class="tab-pane fade">
            <h2>Peter Griffin, Bass player</h2>
            <p>I mean, sometimes I enjoy the show, but other times I enjoy other things.</p>
        </div>
    </div>
</div>

<?php $this->endContent() ?>
