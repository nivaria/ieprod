/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/
/*Agregar la clase last a determinados elementos de las listas*/
var addLast = function(element, numcols){
	$(element).each(function(){
		if(($(element).index($(this))+1)%numcols==0&& $(this).index()!=0){
             $(this).addClass('last');
         }
	});
}
$(function(){
    //Node form position
    /*var jqNodeForm = $("body.page-node #node-form div.node-form");
if(jqNodeForm.length>0){
var jqStand = $("body.page-node #node-form div.node-form > .standard");
var jqRel = $("body.page-node #node-form div.node-form > .relations");
if(jqStand.length>0 && jqRel.length>0){
$("<div class='node-form-cols'></div>").prependTo(jqNodeForm);
jqStand.appendTo(jqNodeForm.find("div.node-form-cols")).css("width","73%").css("float","left");
jqRel.appendTo(jqNodeForm.find("div.node-form-cols")).css("width","25%").css("float","right");
}
}*/
    //Mi actividad hack
    $("body.profile-me #header-group ul.menu li a[href$='/user']").addClass("active");
    //Add Mark all in group page Subscriptions block
    if($("body.node-type-group div.node #node-bottom #block-notifications_ui-0 .content .form-checkboxes .form-item input[type='checkbox']:not(:checked)").length>0){
        $("body.node-type-group div.node #node-bottom #block-notifications_ui-0 .content .form-checkboxes").prepend("<a href='#' title='Marcar todos' class='mark-all'>Marcar todos</a>");
    } else {
        $("body.node-type-group div.node #node-bottom #block-notifications_ui-0 .content .form-checkboxes").prepend("<a href='#' title='Desmarcar todos' class='unmark-all'>Desmarcar todos</a>");
    }
    $("body.node-type-group div.node #node-bottom #block-notifications_ui-0 .content .form-checkboxes a.mark-all").live("click",function(ev){
        ev.preventDefault();
        $(this).parents(".form-checkboxes").find(".form-item input[type='checkbox']").attr("checked","checked").end().end().removeClass("mark-all").addClass("unmark-all").attr("title","Desmarcar todos").html("Desmarcar todos");
        return false;
    });
    $("body.node-type-group div.node #node-bottom #block-notifications_ui-0 .content .form-checkboxes a.unmark-all").live("click",function(ev){
        ev.preventDefault();
        $(this).parents(".form-checkboxes").find(".form-item input[type='checkbox']").removeAttr("checked").end().end().removeClass("unmark-all").addClass("mark-all").attr("title","Marcar todos").html("Marcar todos");
        return false;
    });
    $("body.node-type-group div.node #node-bottom #block-notifications_ui-0 .content .form-checkboxes .form-item input[type='checkbox']").live("click",function(ev){
        if($("body.node-type-group div.node #node-bottom #block-notifications_ui-0 .content .form-checkboxes .form-item input[type='checkbox']:not(:checked)").length>0){
            $("body.node-type-group div.node #node-bottom #block-notifications_ui-0 .content .form-checkboxes a").removeClass("unmark-all").addClass("mark-all").attr("title","Marcar todos").html("Marcar todos");
        } else {
            $("body.node-type-group div.node #node-bottom #block-notifications_ui-0 .content .form-checkboxes a").removeClass("mark-all").addClass("unmark-all").attr("title","Desmarcar todos").html("Desmarcar todos");
        }
    });
    //Comment block Title
    if(Drupal.settings.user && Drupal.settings.user.profile_name){
        if(Drupal.settings.nivaria_contests_base.language=="en"){
            $("#comments .box h2.title").html(Drupal.settings.user.profile_name+", post your comment");
        } else {
            $("#comments .box h2.title").html(Drupal.settings.user.profile_name+", deja tu comentario");
        }
    }
    //Answer block Title
    if(Drupal.settings.user && Drupal.settings.user.profile_name){
        $(".buildmode-full .node-type-faq_question .field-gerencia-reply-form-widget > form > div").prepend("<h2 class='title'>"+Drupal.settings.user.profile_name+", comparte tu respuesta</h2>");
    }
    //Group details page. Taxonomy list styling.
    $(".page-ogdetails .view-group-selected-categories .item-list ul li a.active").parents("li.views-row").addClass("active");
    //Group details page. Move boton edit.
    $("body.page-ogdetails .edit-content-link").prependTo("#content-group").css({
        top: "28px",
        right: "16px"
    });
    //Fix Slideshow error
    if($("html").hasClass("activeSlide")){
        $("html").removeClass("activeSlide");
    }
    //Some improvements for dates
    $("span.date-display-start").each(function(index){
        var todate = $(this).parents(".field-content").find("span.date-display-end");
        if(todate.length>0){
            var from = $(this).html();
            var to = todate.html();

            var arr1 = from.split(" ");
            var arr2 = to.split(" ");
            for(var i=arr2.length-1;i>=0;i--){
                if(arr2[i]===arr1[i]){
                   arr1 = arr1.slice(0,i);
                } else {
                    break;
                }
            }
            if(arr1.length==2){
               arr1 = arr1.slice(0,1);
            }

            $(this).html(arr1.join(" "));
        }
    });

    // Switch top menu based on scoll position
    if ($('body').is('.admin-menu')) {
      var adminHeight = 20;
    } else {
      var adminHeight = 0;
    }

    adminHeight = adminHeight + 140;

    $(window).scroll(function () {
        if ($(this).scrollTop() > adminHeight) {
            $('#header-large-inner').hide(200);
            $('#header-small-wrapper').show(200);
            $('#header-region-following').addClass('fixed-menu');
            $('#main-wrapper').addClass('fixed-menu-page');
        } else {
            $('#header-large-inner').show(200);
            $('#header-small-wrapper').hide(200);
            $('#header-region-following').removeClass('fixed-menu');
            $('#main-wrapper').removeClass('fixed-menu-page');
        }
    });
	
	/*-------------------------------------------------------
	Adaptación para el área de usuario en edicion de cuentas.
	DLTC 1-1-12
	--------------------------------------------------------*/
	/*Clase last en el tercer elemento de cada fila de la lista de proyectos en la ficha de usuario*/
	addLast('.item-list ul li.views-row', 3);
	/*SANTI: This was temporary, all this changes should be done in the CMS-PHP and not in JS, i did this only to go ahead with the layout not to keep them in the production version, the explanations are now before each script */
	
	/*El enlace a "mi cuenta" en el área de ficha de usuario ha de tener la clase account*/
	/*
	Explanation #1:
	The "My account" link in the user menu should had the class "account"
	*/
	if(
		$('.header .tabs.primary').find('li:last').children('a').text()=="My account"||
		$('.header .tabs.primary').find('li:last').children('a').text()=="Mi cuenta"
	){
			$('.header .tabs.primary').find('li:last').addClass('account');	
	}
	
	/*
	Explanation #2:
	There's not #sidebar-last in the main page of the user profile, as in this page is a sidebar-first and there's not space for the content between both.
	*/
	if($('.entrada-ficha').length){
            $('#sidebar-last').remove();
	}else{
	/*
	Explanation #3:
	If we are'nt in the main page of the user profile the sidebar-first ONLY contains the image, but not the rest of the fields, as theres's a #sidebar-last in this areas
	*/
     $('.view-arqnetwork-user-profile .views-field-field-address-acp-value, .view-arqnetwork-user-profile .views-field-field-company-acp-value, .view-arqnetwork-user-profile .views-field-phpcode-1, .view-arqnetwork-user-profile .views-field-field-small-description-acp-value, .view-arqnetwork-user-profile .views-field-phpcode, .view-arqnetwork-user-profile .views-field-field-facebook-acp-url, .view-arqnetwork-user-profile .views-field-field-google-acp-url, .view-arqnetwork-user-profile .views-field-field-linkedin-acp-url, .view-arqnetwork-user-profile .views-field-field-pinterest-acp-url, .view-arqnetwork-user-profile .views-field-field-twitter-acp-url').remove();
	}
	$('.inscription-dates').find('div').each(function(){
		if($(this).text()==""){$(this).hide()}
	})
	$('#main-content .view-user-directory .views-exposed-wrapper').find('.views-exposed-submit').appendTo('.views-exposed-widgets');
        
        //Scripts to apply after AJAX reloads in pages
        Drupal.behaviors.arquideasTheme = function(context) {
            addLast('#view-id-arqnetwork_user_projects-page_1 .item-list ul li.views-row', 3);
            
            //Followers hack
            if($(".view-profile-follower .views-view-grid td").length){
                $(".view-profile-follower .views-view-grid td").each(function(){
                    $(".views-field-user-badges-html .user_badges img",this).each(function(index){
                        if(index>0){
                            $(this).remove();
                        } 
                    });
                });
            }
            
            //Links inside facebook status content must have target _blank attribute
            if($(".facebook-status-item .content a").length){
                $(".facebook-status-item .content a").attr("target","_blank");
            }
        }
        
        //Join group for anonymous should open login form
        $("body.not-logged-in .view .views-field-leave-group .join a").addClass("thickbox").each(function(){
            var arr = $(this).attr("href").split("?");
            var url = "ajax_register/login";
            if(arr.length>1){
                url = url + "?" +arr[1];
            }
            $(this).attr("href",url);
        });
        tb_init("body.not-logged-in .view .views-field-leave-group .join a.thickbox");
        
        //One trick for News page
        $("body.page-news .view-news .view-header h3.subtitle").insertBefore("#content-group");
        
        //DOM manipulations for solr users page, projects page, network page
        $("body[id^='pid-solr-nodetype-arquideas-content-profile'] #content-front-left .block-nodeblock h2.title").each(function(index){
           if(index==0){
               var m_html = $(this).html();
               $(this).insertBefore("#content-front-left").replaceWith("<h1 class='title'>"+m_html+"</h1>");
           } 
        });
        $("body[id^='pid-solr-nodetype-arquideas-content-profile'] #content-front-left .block-nodeblock .content h2").each(function(index){
           if(index==0){
               $(this).addClass("subtitle").insertBefore("#content-front-left");
           } 
        });
        $("body[id^='pid-solr-nodetype-multi-project-inscription'] #content-front-left .block-nodeblock h2.title").each(function(index){
           if(index==0){
               var m_html = $(this).html();
               $(this).insertBefore("#content-front-left").replaceWith("<h1 class='title'>"+m_html+"</h1>");
           } 
        });
        $("body[id^='pid-solr-nodetype-multi-project-inscription'] #content-front-left .block-nodeblock .content h2").each(function(index){
           if(index==0){
               $(this).addClass("subtitle").insertBefore("#content-front-left");
           } 
        });
        $("body.page-arquideas-network #content-front-left .block-nodeblock h2.title").each(function(index){
           if(index==0){
               $(this).removeClass("title").removeClass("block-title").addClass("subtitle").insertBefore("#content-front-left");
           } 
        });
        
        //DOM manipulation for project details
        $("body.page-node.node-type-project #comments .box").appendTo(".full-node.node-type-project .project-info-public .col01");
        $("body.page-inscription #comments .box").appendTo(".full-node.page-inscription .inscription-info-public .col01");
        
        //Cambio en el DOM
	if($('.arquideas-network').length || $('.page-solr-nodetype').length || $('.page-solr-nodetype-multi').length){
            $('#content-front-left .login-and-register-link-div').css('display','inline-block').removeClass('login-and-register-link-div').addClass('login-and-register-link-div-2').appendTo('#block-arquideas_generic-4 .users-total');
	}
        
        //One more fix for calendar
        $("#pid-content-events-calendar #content-group").addClass("grid16-16").addClass("force-width").css("width","960px");
        
        //Change image link for users
        $(".view-arqnetwork-user-profile .views-field-phpcode-2 a.user-edit-image-link").parents(".views-field-phpcode-2").addClass("user-edit-image").appendTo(".view-arqnetwork-user-profile .views-field-picture");

		//Centrado vertical textos en partners
		
		if($('.page-partners-and-co').length){
			$('.view-colaborators .view-content').find('.views-row').each(function(){
				$(this).find('.views-field-phpcode,.views-field-view-node, views-field-field-comment-title-col-value').appendTo(
					jQuery('<span class="inner-partner"/>').appendTo($(this))
				)
			})
		}
		
		if($('.jq-scrollable-inscription .scrollable').length){
			$('#scrollable').find('.caption').each(function(){
				$(this).html('<p>'+$(this).html()+'</p>')
				jQuery('<div class="alpha"/>').prependTo($(this))
			})
		}
		/*if($('.inscription-info-public .col02 .project-prize').length){
			$('.project-prize').html('<p>'+$('.project-prize').html()+'</p>');
			jQuery('<div class="alpha"/>').prependTo($('.project-prize'));
		}*/
		//Si estamos en inscripcion y no es inscripci�n grupal
		if($('.node-type-inscription').length&&!$('.only-groups').length){
			$('.node-type-inscription .contest-payment-individual').css({
				'float': 'left',
				marginLeft: '60px',
				marginTop: '-25px'
			})
			$('.node-type-inscription .contest-payment-group').css({
				'float': 'right',
				marginRight: '60px',
				marginTop: '-25px'
			})
			$('.open-contest-button').css({marginLeft: '0',marginTop:'20px'});
                        $('.open-contest-button > .info').css({marginLeft: '345px'});
		}
		if($('.node-type-inscription.launch-overlay').length){
	                var m_wall_text = "Create a team and enjoy of this collaborative area with all its members !!";
        	        if(Drupal.settings.nivaria_contests_base.language=="es"){
                	    m_wall_text = "¡¡ Forma un equipo y disfruta de este área colaborativa con todos sus miembros !!";
                	}
			jQuery('<div class="WallOverlay"/>').css({bottom: '0',
  				 	left:   '0',
   					top:    '0',
					position: 'absolute',
    				width: '100%'
				}).html('<div class="alpha"></div><span class="inner clearfix"> '+m_wall_text+' </span>').prependTo('#block-quicktabs-arqnetwork_group_quicktabs');
		}
		if($('.view-arqnetwork-account-inscriptions .views-row').length){
			$('.view-arqnetwork-account-inscriptions .views-row').each(function(){
				if(
					!$(this).find('.jquery-countdown').length
					&&
					$(this).find('.views-field-phpcode-4').find('.info').text()==""
					&&
					$(this).find('.views-field-phpcode-5').find('.info').text()==""
				){
						$(this).find('.views-field-phpcode-2').css({
						marginRight: '0',
						'float': 'none'
					})
				}
			})
		}
		$('.sidebar-first .view-arqnetwork-user-profile .views-field-picture').hover(function(){
			$(this).find('.user-edit-image').fadeIn()
                    },
                    function(){
                        $(this).find('.user-edit-image').fadeOut()
		});
                //Hide terms label in compound files
                $(".field-inscription-files-by-category select").each(function(index){
                   var m_id = $(this).attr("id");
                   $("label[for='"+m_id+"']").hide();
                });
                //Fivestar adjusts
                $(".fivestar-widget .fivestar-form-item .description .user-rating").each(function(){
                   var m_check = $(this).find("span").html();
                   if(m_check=="None"){
                       $(this).html("Vote!");
                   }
                   if(m_check=="Ninguno"){
                       $(this).html("¡Vota!");
                   }
                });
                //Home menu
                $(".logged-in #menu-homepage-lorem.menu-homepage-mybook-anonym").parents("li").remove();
                //Followers hack
                $(".view-profile-follower .views-view-grid td").each(function(){
                    $(".views-field-user-badges-html .user_badges img",this).each(function(index){
                        if(index>0){
                            $(this).remove();
                        } 
                    });
                });
                //Remove wall for individual payment
                if($(".node.individual-payment").length){
                    $("#block-quicktabs-arqnetwork_group_quicktabs").remove();
                }
                
                //Move create content
                if($(".node-type-group.full-node #sidebar-last #block-commons_core-group_create_content").length){
                    $(".node-type-group.full-node #quicktabs-arqnetwork_group_quicktabs ul.quicktabs_tabs").append("<li class='create-content-block'></li>");
                    $(".node-type-group.full-node #sidebar-last #block-commons_core-group_create_content").appendTo(".node-type-group.full-node #quicktabs-arqnetwork_group_quicktabs ul.quicktabs_tabs li.create-content-block");
                } else if($(".page-arquideas-network #sidebar-last #block-commons_core-group_create_content").length){
                    $("#block-facebook_status-facebook_status .inner .content").prepend("<div class='clearfix'></div>");
                    $(".page-arquideas-network #sidebar-last #block-commons_core-group_create_content").prependTo("#block-facebook_status-facebook_status .inner .content");
                } else {
                    //Title for create content
                    var m_create_title = "Create content to share with your groups";
                    if(Drupal.settings.nivaria_contests_base.language=="es"){
                        m_create_title = "Crea contenido para compartir con tus Grupos";
                    }
                    $("#block-commons_core-group_create_content .inner").prepend("<h2 class='title block-title'>"+m_create_title+"</h2>");
                }
                //Deadline tab fixes
                $(".view-contest-blocks.view-display-id-block_3 table tr").each(function(){
                   $("td",this).each(function(index){
                      if(index==1){
                          $(this).css("font-size","14px");
                      } 
                   }); 
                });
                //Follow site links
                $("#block-follow-site .follow-links a").attr("target","_blank");
                //Fix Collaborates and Sponsors in competition details
                if($("#block-views-sponsors-block_1 .content .view-empty").length){
                    $("#block-views-sponsors-block_1 h2.title").prependTo("#block-views-sponsors-block_2 .inner");
                    $("#block-views-sponsors-block_2").addClass("single-line");
                    $("#block-views-sponsors-block_1").remove();
                }
                if($("#block-views-sponsors-block_3 .content .view-empty").length){
                    $("#block-views-sponsors-block_3 h2.title").prependTo("#block-views-sponsors-block_4 .inner");
                    $("#block-views-sponsors-block_4").addClass("single-line");
                    $("#block-views-sponsors-block_3").remove();
                }
                if($("#block-views-sponsors-block_2 .content .view-empty").length){
                    $("#block-views-sponsors-block_2").remove();
                }
                if($("#block-views-sponsors-block_4 .content .view-empty").length){
                    $("#block-views-sponsors-block_4").remove();
                }
                //Some fixes for internal admin pages
                if($("#page.page-full-view .view-full-page .views_slideshow_singleframe_slide").length){
                    $("#page.page-full-view .view-full-page .views_slideshow_singleframe_slide .views-field-title a").attr("target","_blank");
                    $("#page.page-full-view .view-full-page .views_slideshow_singleframe_slide #scrollable .items a").attr("target","_blank");
                    $("#page.page-full-view .view-full-page .views_slideshow_singleframe_slide .views-field-field-inscription-members-list-vname a").attr("target","_blank");
                }
                //Links inside facebook status content must have target _blank attribute
                if($(".facebook-status-item .content a").length){
                    $(".facebook-status-item .content a").attr("target","_blank");
                }
                //Large texts inside activity stream on front page must be cutted to 70 symbols.
                if($(".front .facebook-status-item .content .facebook-status-content").length){
                    $(".front .facebook-status-item .content .facebook-status-content").each(function(){
                        var m_text = $(this).text();
                        if(m_text.length>70){
                            $(this).html(m_text.substr(0,70)+"...");
                        }
                    });
                }
                //Invite users page buttons
                if($("#og-invite-link-invite-page-form").length){
                    $("#block-arquideas_generic-16").appendTo("#og-invite-link-invite-page-form > div");
                }
                //Blocks in inscription details
                if($("body.area-social .contest-info .two-columns").length){
                    $("#node-869 .content h3").addClass("title");
                    $("#node-869 .content > div").addClass("deadline-date").style("margin-left","0");
                    
                    var m_h = 0;
                    $("body.area-social .contest-info .two-columns > div").each(function(){
                       var m_h1 = $(this).height();
                       if(m_h1>m_h){
                           m_h = m_h1;
                       }
                    });
                    $("body.area-social .contest-info .two-columns > div").height(m_h);
                    
                    
                }

});

$(window).load(function(){
    var max = Math.max.apply(Math, $(".scrollable").children().map(
      function(){
        return $(this).height();
      }
    ).get());
    $(".scrollable").height(max); 
	$(".scrollable .items").find('div').each(function(){
		if($(this).attr('class')==""){
			$(this).addClass('slide');
		}
	});
	$('.jq-scrollable-inscription .browse').click(function(){
   		altura=$('.items div.slide:eq('+$('.scrollable').scrollable().getIndex()+')').height();
   		$('.scrollable').animate({
			height: ''+altura+'px'
		},500);
   });
   
   ///Ajustes de las alturas de los slides
   $(".views_slideshow_main").each(function(){
			//Calculamos la altura de la capa de controles
			plusheight=$(this).next().height()
			//Calculamos la altura de llas im�genes dentro del slideshow una vez que se hayan cargado
			var max = Math.max.apply(Math, $(this).find('.views-row').map(
		      function(){
		        return $(this).height();
		      }
		    ).get());
                        
			//Asignamos la altura a los contenedores de slides
		    $(this).find(".views_slideshow_singleframe_teaser_section").css({'min-height':max+plusheight+2+"px", 'min-width':'100%'}); 
			$(this).find(".views_slideshow_slide").css({'min-height':max+plusheight+2+"px", 'min-width':'100%'}); 
	});
    //Addthis block adjustment
    $("#block-arquideas_generic-13 .widget-body .fb-send").prependTo("#block-arquideas_generic-13 .widget-body .addthis_toolbox").addClass("addthis_toolbox_item");
    if($("#block-arquideas_generic-13").length){
      var w = "100px";
      if($("body").hasClass("node-type-contest")){
          w = "300px";
      }
      $("#block-arquideas_generic-13 .widget-body .addthis_toolbox .addthis_toolbox_item > iframe").css("width",w);
      $("#block-arquideas_generic-13 .widget-body .addthis_toolbox > .fb_send").css("width",w);
      $("#block-arquideas_generic-13 .widget-body .addthis_toolbox .addthis_toolbox_item > .fb-like").css("width",w);
      $("#block-arquideas_generic-13 .widget-body .addthis_toolbox .addthis_toolbox_item > iframe").css("height","20px");
    }
    //Footer solution by image
    $("#block-powered_by_nivaria-0 .content > a.nivaria > img").attr("usemap","#solutionmap");
    var imgcode = $("#block-powered_by_nivaria-0 .content > a.nivaria").html();
    imgcode += "<map name=\"solutionmap\">";
    imgcode += "<area shape=\"rect\" coords=\"0,0,138,22\" href=\"http://www.arquideas.net\" alt=\"Arquideas\" target=\"_blank\" >";
    imgcode += "<area shape=\"rect\" coords=\"138,0,216,22\" href=\"http://www.nivaria.com\" alt=\"Nivaria\" target=\"_blank\" >";
    imgcode += "</map>";
    $("#block-powered_by_nivaria-0 .content > a.nivaria").replaceWith(imgcode);
    //Request password page
    if($("#pid-user-password").length){
        $("#pid-user-password #user-pass .user-password-fs").removeClass("collapsed");
    }
});
