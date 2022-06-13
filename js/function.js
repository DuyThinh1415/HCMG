// Action when load page:
$(document).ready(function() {
    showProdSlides();
    showNewProd();
    showUserLib();
    $.ajax({
        url: 'php/api/isLogged_toggle.php',
        success: function(response){
            let show = response['show'], hide = response['hide'];
            for (let i=0; i<show.length; i++){
                let element = show[i];
                $(element).toggleClass('hidden', false);
            }
            for (let i=0; i<hide.length; i++){
                let element = hide[i];
                $(element).toggleClass('hidden', true);
            }
        }
    });
});

$(window).load(function(){
    document.getElementsByTagName("html")[0].style.visibility = "visible";
    if (isLogged == true) purchasedOrNot();
})

// Function: Sign up
$("body").on("click", "#btn-signUp", function(e){
    e.preventDefault();
    let formData = $('#signUp-form').serialize();

    $.ajax({
        type: 'POST',
        url: 'php/api/signup.php',
        data: formData,
        success: function(response){
            let msg = response['message'];
            $('#alert-signUp').html("<script>window.alert('"+msg+"');</script>");
            if (response['status'] == 'succ') $('#alert-signUp').append("<script>window.location.replace('index.php');</script>");
        }
    });
});

// Function: Sign in 
$("body").on("click", "#btn-signIn", function(e){
    e.preventDefault();
    let formData = $('#signIn-form').serialize();

    $.ajax({
        type: 'POST',
        url: 'php/api/signin.php',
        data: formData,
        success: function(response){
            let msg = response['message'];
            $('#alert-signIn').html("<script>window.alert('"+msg+"');</script>");
            if (response['status'] == 'succ_admin') $('#alert-signUp').append("<script>window.location.replace('index.php');</script>");
            else if (response['status'] == 'succ_user') $('#alert-signIn').append("<script>window.location.replace('index.php');</script>");
        }
    });
});

// Function: Log outlement.style
$("body").on("click", ".btn-logOut", function(e){
    let ans = window.confirm("Do you really want to logout?");
    if (ans){
        window.location.replace('php/api/logout.php');
    }
});

/* For get variables from product

let Prod_id = item['Product_id'], Name = item['Name'], Desp = item['Description'], Type = item['Type'],
    Prod_studio = item['Produce_studio'], Price = item['Price'], Bg_img = item['Background_image'], Sqr_img = item['Square_image'],
    S_img1 = item['Small_image1'], S_img2 = item['Small_image2'], S_img3 = item['Small_image3'];

*/

// Function: Load product to home slider when page load
function showProdSlides(){
    $.ajax({
        type: 'POST',
        url: 'php/api/load_slides.php',
        success: function(response){
            let prod_list = response['data'];
            for (var i=0; i<prod_list.length; i++){
                let item = prod_list[i];
                let Prod_id = item['Product_id'], Name = item['Name'], Desp = item['Description'],
                    Price = item['Price'], Bg_img = item['Background_image'],
                    S_img1 = item['Small_image1'];
                let li = $('<li data-bg-image="#"></li>');
                //console.log(S_img1);    
                li.attr("data-bg-image", S_img1);
                li.append('<div class="container">\
                <div class="slide-content">\
                <h2 class="slide-title">'+Name+'</h2>\
                <small class="slide-subtitle">$'+Price+'.00</small> \
                <p style="font-size: 20px; text-align: justify;">'+Desp+'</p>\
                <a href="#" class="button toCart hidden" data-prod-id="'+Prod_id+'">Add to cart</a>\
                <a href="#" class="button isPurchased hidden" data-prod-id="'+Prod_id+'"><i class="icon-wallet"></i> Owned</a>\
                </div> \
                <img src="'+Bg_img+'" class="slide-image">\
                </div>');
                $("ul.slides").append(li);                    
            }
        }
    });
}

// Function: Load product to section New Product
function showNewProd(){
    $.ajax({
        type: 'POST',
        url: 'php/api/load_newProd.php',
        success: function(response){
            let prod_list = response['data'];
            for (var i=0; i<prod_list.length; i++){
                let item = prod_list[i];
                let Prod_id = item['Product_id'], Name = item['Name'], Desp = item['Description'], 
                    Price = item['Price'], Bg_img = item['Background_image'];
                let div = $('<div class="product" data-prod-id="'+Prod_id+'"></div>');
                div.append('<div class="inner-product">\
                <div class="figure-image">\
				<a href="#"><img src="'+Bg_img+'" alt="'+Name+'"></a>\
				</div>\
                <h3 class="product-title"><a href="#">'+Name+'</a></h3>\
                <small class="price">$'+Price+'.00</small>\
                <p>'+Desp+'</p>\
                <a href="#" class="button toCart hidden" data-prod-id="'+Prod_id+'">Add to cart</a>\
                <a href="#" class="button isPurchased hidden" data-prod-id="'+Prod_id+'"><i class="icon-wallet"></i> Owned</a>\
                <a href="#" class="button muted">Read Details</a>\
                </div>');
                $("#sec_newProd div.product-list").append(div);                    
            }
        }
    });
}

// Function: Load user library to section Library
function showUserLib(){
    if (userId){
        $.ajax({
            type: 'GET',
            url: 'php/api/load_userLib.php?User_id='+userId,
            success: function(response){
                let prod_list = response['data'];
                if (!prod_list.length){
                    $("#empty_lib").removeClass("hidden");
                    $("#lib_asUser").addClass("hidden");
                }
                else{
                    $("#empty_lib").addClass("hidden");
                    $("#lib_asUser").removeClass("hidden");
                    for (var i=0; i<Math.min(4, prod_list.length); i++){
                        let item = prod_list[i];
                        let Prod_id = item['Product_id'], Name = item['Name'], Desp = item['Description'], Type = item['Type'],
                            Prod_studio = item['Produce_studio'], Price = item['Price'], Bg_img = item['Background_image'], Sqr_img = item['Square_image'],
                            S_img1 = item['Small_image1'], S_img2 = item['Small_image2'], S_img3 = item['Small_image3'];
                        let div = $('<div class="product" data-prod-id="'+Prod_id+'"></div>');
                        div.append('<div class="inner-product">\
                        <div class="figure-image">\
                        <a href="#"><img src="'+Bg_img+'" alt="'+Name+'"></a>\
                        </div>\
                        <h3 class="product-title"><a href="#">'+Name+'</a></h3>\
                        <small class="price">$'+Price+'.00</small>\
                        <p>'+Desp+'</p>\
                        <a href="#" class="button muted">Read Details</a>\
                        </div>');
                        $("#lib_asUser").append(div);                    
                    }
                }
            }
        });
    }
}

//Function: navigate to homepage
$("body").on("click", ".nav-home", function(e){    
    setTimeout(function(){window.location.replace('index.php');},200);
});

//Function: check if product is purchased -> change button Add to cart to Purchased
function purchasedOrNot(){
    let Prod_list = $('.toCart');
    for (var i = 0; i < Prod_list.length; i++) {
        let Prod_id = parseInt($(Prod_list[i]).attr('data-prod-id'));
        $.ajax({
            type: 'POST',
            data: jQuery.param({Product_id: Prod_id, User_id: userId}),
            url: 'php/api/check_isPurchased.php',
            success: function(response){
                if (response['checker'] == true){
                   // $(Prod_list[i]).addClass('hide');
                    //$('.isPurchased').filter('[data-prod-id="'+Prod_id+'"]').removeClass('hidden');
                    $('.toCart[data-prod-id="'+Prod_id+'"]').toggleClass("hidden", true)
                    $('.isPurchased[data-prod-id="'+Prod_id+'"]').toggleClass('hidden', false);
                }
            }
        });
    }
}