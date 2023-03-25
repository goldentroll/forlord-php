$(document).ready(function(t) {
  t.preventDefault();
  var r = e.querySelector(".submenu");
  r.classList.contains("active") ? r.classList.remove("active") : r.classList.add("active")
});


document.addEventListener('DOMContentLoaded', function(){    
     
    // SWITCHING PLANS IN FRONTPAGE CALCULATOR
    $('.investors-item').click(function(){
        $('.investors-item').removeClass('active');
        $(this).addClass('active');
        // getting plan data
        let percent = $(this).attr('data-percent');
        let name = $(this).attr('data-name');
        let min = $(this).attr('data-min');
        let max = $(this).attr('data-max');
		

        // paste data in calc block
        $('.number').html(`${percent}%`);
        $('.calc-label').html(name);
        $('#min').html(`${min}$`);
        $('#max').html(`${max}$`);
        $('.calc-amount-row [name="calc-amount"]').val(min);

        frontCalc(percent, min);
    });
    	
});

function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  document.execCommand("copy");
  
} 


$(document).ready(function(){
  $('.pay').owlCarousel({
    loop:true,
    margin:10,
	autoplay:false,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    nav:false,
	dots:false,
    responsive:{
        0:{
            items:1
        },
		320:{
            items:1
        },
		480:{
            items:2
        },
        600:{
            items:3
        },
		767:{
            items:4
        },
		991:{
            items:5
        },
        1200:{
            items:6
        }
    }
});
});	



$(document).ready(function(){
  $('.tras1').owlCarousel({
    loop:true,
    margin:10,
	autoplay:false,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    nav:false,
	dots:false,
    responsive:{
        0:{
            items:1
        },
		320:{
            items:1
        },
		480:{
            items:1
        },
        600:{
            items:1
        },
		767:{
            items:1
        },
		991:{
            items:1
        },
        1200:{
            items:1
        }
    }
});
});	

$(document).ready(function(){
  $('.tras2').owlCarousel({
    loop:true,
    margin:10,
	autoplay:false,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    nav:false,
	dots:false,
    responsive:{
        0:{
            items:1
        },
		320:{
            items:1
        },
		480:{
            items:1
        },
        600:{
            items:1
        },
		767:{
            items:1
        },
		991:{
            items:1
        },
        1200:{
            items:1
        }
    }
});
});


 $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
  });
  
  $(document).ready(function(){
  $('.quick-list').owlCarousel({
    loop:true,
    margin:10,
	autoplay:false,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    nav:false,
	dots:false,
    responsive:{
        0:{
            items:1
        },
		320:{
            items:1
        },
		480:{
            items:2
        },
        600:{
            items:2
        },
		767:{
            items:3
        },
		991:{
            items:3
        },
        1200:{
            items:3
        }
    }
});
});	


