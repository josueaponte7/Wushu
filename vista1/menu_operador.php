<?php ?>
<!doctype html>
<html>
    <head>
        <!-- Load jQuery from Google's CDN -->
        <script src="../js/jquery-1.11.0.js"></script>
        <style type="text/css">
            h1 {
                font-family: Helvetica;
                font-weight: 100;
            }
            body {
                color:#333;
                text-align:center;
                font-family: arial;
            }

            .nav {
                margin: 0px;
                padding: 0px;
                list-style: none;
            }

            .nav li {
                float: left;
                width: 160px;
                position: relative;
            }

            .nav li a {
                background: #333;
                color: #fff;
                display: block;
                padding: 7px 8px;
                text-decoration: none;
                border-top: 1px solid #069;
            }

            .nav li a:hover {
                color: #069;
            }

            /*=== submenu ===*/

            .nav ul {
                display: none;
                position: absolute;
                margin-left: 0px;
                list-style: none;
                padding: 0px;
            }

            .nav ul li {
                width: 160px;
                float: left;
            }

            .nav ul a {
                display: block;
                height: 15px;
                padding: 7px 8px;
                color: #fff;
                text-decoration: none;
                border-bottom: 1px solid #222;
            }

            .nav ul li a:hover {
                color: #069;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.nav li').hover(
                        function() { //appearing on hover
                            $('ul', this).fadeIn();
                        },
                        function() { //disappearing on hover
                            $('ul', this).fadeOut();
                        }
                );
            });
        </script>
    </head>
    <body>
        <!-- Use this navigation div as your menu bar div -->
        <div class="navigation">
            <ul class="nav">
                <li>
                    <a href="#">Home</a>
                </li>
                <li>
                    <a href="#">Services</a>
                    <ul>
                        <li><a href="#">Consulting</a></li>
                        <li><a href="#">Sales</a></li>
                        <li><a href="#">Support</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">About Us</a>
                    <ul>
                        <li><a href="#">Company</a></li>
                        <li><a href="#">Mission</a></li>
                        <li><a href="#">Contact Information</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </body>
</html>