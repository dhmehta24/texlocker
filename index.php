<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel = "icon" href="txlckr-icon.png" type="image/x-icon">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">&nbsp;
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
    <title>Texlocker | Share Text Online</title>
</head>
<style>
    html, body {
        height: 100%;
        margin: 0px;
    }
    .light-placeholder{
        border-color: black;
        color: black;
    }
    .light-placeholder::-webkit-input-placeholder{
        color: #718096;
    }
    .liftanim {visibility:hidden;}
    .liftUp {
        animation-name: liftUp;
        animation-duration: 1s;
        visibility: visible;
    }
    @keyframes liftUp {
        0% {
            opacity: 0;
            transform: translateY(70%);
        }
        100% {
            opacity: 1;
            transform: translateY(0%);
        }
    }

</style>
<body class="bg-gray-900">
<script>
    function send_to_php(){
        if (!$("#clue").val()) {
            $("#clue").addClass("is-invalid")
        }
        else{
            if (!$("#text-body-entry").val()) {
                $("#text-body-entry").addClass("is-invalid")
                return
            }
            $("#text-body-entry,#clue").removeClass("is-invalid")
            $.ajax({
                type: "POST",
                url: "send_data.php",
                data:$("#data-form").serialize(),
                success: function (response) {
                    $("#play").slideUp("slow");
                    $("#text-body-entry,#clue").slideUp()
                    toastr.options = {
                        "positionClass": "toast-top-left",
                        "timeOut" : "1500",
                    }
                    toastr["success"]("Your Text Has Been Shared Sucessfully : )", "Success :)")
                    $("#clue").val('')
                    $("#submit").unbind()
                },
                error : function(){
                    toastr.options = {
                        "positionClass": "toast-top-left",
                        "timeOut" : "1500",
                    }
                    toastr["danger"]("Data Not Sent :(", "Error !! :(")
                }
            })
        }
    }

    function get_php(){
        if(!$("#clue").val()){
            $("#clue").addClass("is-invalid")
        }
        else{
            $("#clue").removeClass("is-invalid")
            $.ajax({
                type:"POST",
                url: "receive_data.php",
                data: {
                    "clue": $("#clue").val(),
                },
                success : function(response){
                    $("#text-body-entry").removeClass("is-invalid")
                    $("#text-body-entry").slideDown("slow")
                    $("#text-body-entry").val(response)
                    $("#text-body-entry").attr("readonly","readonly")
                    $("#text-body-entry").scrollTop(0)
                    $("#submit").off("click")
                },
            })
        }
    }

    $(document).ready(function(){

        $(".liftanim").each(function(){
            $(this).addClass("liftUp");
        });

        $("#gettext").on("click",function(){
            if($("#text-body-entry").is(":visible")){
                $("#text-body-entry").slideUp("fast")
            }
            $("#footer").slideDown("slow")
            $("#submit").html("Get")
            $("#submit").attr("onclick","get_php()")
            $("#play,#clue").slideDown("slow")
            $("#clue,#text-body-entry").val('')
            $("html,body").animate({
                scrollTop: $("#clue").offset().top - 120
            },1000);
        })

        $("#sharetext").on("click",function () {
            if($("#clue").is(":visible")){
                $("#clue").slideUp("fast")
            }
            $("#footer").slideDown("slow")
            $("#submit").removeAttr("onclick","get_php()")
            $("#text-body-entry").removeAttr("readonly","readonly")
            $("#play").slideDown("slow")
            $("#text-body-entry").slideDown("slow")
            $("#text-body-entry,#clue").val('')
            $("#submit").addClass("data-enter-prompt")
            $("#submit").html("Next")
            $("html,body").animate({
                scrollTop: $("#text-body-entry").offset().top - 120
            },1000);
            $("#submit").on("click",function(){
                if(!$("#text-body-entry").val()){
                    $("#text-body-entry").addClass("is-invalid")
                }
                else{
                    $("#text-body-entry,#clue").removeClass("is-invalid")
                    $("#clue").slideDown("slow")
                    $(this).html("Share...")
                    $(this).attr("onclick","send_to_php()")
                }
            })
        })

        $("#mode").on("click",function(){
            $("body").toggleClass("bg-gray-900 bg-gray-100")
            $("#jumbotext, #clue, #text-body-entry").toggleClass("text-white text-dark")
            $(this).toggleClass("dark light")
            $("#icon").toggleClass("fa-moon-o fa-sun-o")
            $("#icon").toggleClass("text-blue-500 text-orange-500")
            $("#copyright-text").toggleClass("text-gray-900")
            $("input,textarea").toggleClass("light-placeholder")
        })

        $("form").submit(function(e){
            e.preventDefault()
        })
    });

</script>
<button class="btn btn-link m-3 dark" id = "mode" data = "dark" style="color: orange;z-index: 10;position: fixed;top: 0px;right: 0px;"><i id = "icon" class="fa fa-sun-o fa-lg"></i></button>
<div class = "toast m-4" style="z-index: 10;position: fixed;top: 0px;left: 0px;" role="alert" aria-live="polite" aria-atomic="true">
    <div class = "toast-header bg-success">
        <strong>Success :)</strong>
    </div>
    <div class = "toast-body bg-success">
        <strong>Success !!</strong>Your Text has been Stored :)
    </div>
</div>
<div class="container-fluid my-auto align-middle" id="jumboParent" style="height: 70vh;!important;">
    <div class="align-middle text-white liftanim" id="jumbotext" style="margin-top: 170px;!important;">
        <div class="container text-center align-middle">
            <h1 class="display-3">Texlocker</h1>
            <p class="lead mt-2 mr-2">Share Text Online</p>
        </div>
        <div class="container text-center mt-5">
            <div class="row w-100 mt-5">
                <div class="col-md-6 mt-5">
                    <button class="btn btn-outline-secondary btn-block rounded" id = "gettext">Get Text</button>
                </div>
                <div class="col-md-6 mt-5">
                    <button class="btn btn-outline-secondary btn-block rounded" id = "sharetext">Share Text</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" style="height: 100vh;!important;display: none" id = "play">
    <div class = "container">
        <div class="row mt-5 w-100">
            <form method="post" class="w-100" id = "data-form" novalidate>
                <div class="row w-100">
                    <div class="form-group w-100 col-8">
                        <input type="text" class="form-control bg-transparent text-white" name="text-title"
                               placeholder="Suitable Text Title" id="clue" style="display: none">
                    </div>
                    <div class="col-4">
                        <button type="button" id="submit" class="btn btn-outline-success btn-block">Submit Text</button>
                    </div>
                </div>
                <div class="row w-100">
                    <div class="form-group w-100 col-md-12 mt-3">
                    <textarea name="text-body" id="text-body-entry" class="form-control bg-transparent text-white" placeholder="Detailed Data"
                              style="resize: none;height: 500px;display: none"></textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<footer class="text-gray-700 body-font"  id="footer"  style="position: relative;float: bottom;bottom: 0px;left: 0px;right: 0px;display: none;">
    <div class="container px-5 py-8 mx-auto flex items-center sm:flex-row flex-col">
        <a class="flex title-font font-medium items-center md:justify-start justify-center text-gray-900">
            <a href = "index.php" style="text-decoration: none;" class = "ml-3 text-xl mt-4 mb-1"><span class="ml-3 text-xl mt-4 mb-1">Texlocker</span></a>
        </a>
        <p class="text-sm text-gray-500 sm:ml-4 sm:pl-4 sm:border-l-2 sm:border-gray-500 sm:py-2 sm:mt-0 mt-4" id="copyright-text">©2020 Texlocker —
            <a href="https://github.com/dhmehta24" class="text-gray-600 ml-1" rel="noopener noreferrer" target="_blank">@dhmehta24</a>
        </p>
        <span class="inline-flex sm:ml-auto sm:mt-0 mt-4 justify-center sm:justify-start">
                    <a href = "https://github.com/dhmehta24" target = "_blank"><i class = "fa fa-github fa-2x"></i></a>
                </span>
    </div>
</footer>
</body>
</html>

