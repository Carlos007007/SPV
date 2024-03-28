$(document).ready(function(){
    $(".chat-button").on('click', function(e){
        e.preventDefault();
        $(".chat-content").slideToggle('fast');
    });
	$('.btn-sideBar-SubMenu').on('click', function(e){
		e.preventDefault();
		var SubMenu=$(this).next('ul');
		var iconBtn=$(this).children('.zmdi-caret-down');
		if(SubMenu.hasClass('show-sideBar-SubMenu')){
			iconBtn.removeClass('zmdi-hc-rotate-180');
			SubMenu.removeClass('show-sideBar-SubMenu');
		}else{
			iconBtn.addClass('zmdi-hc-rotate-180');
			SubMenu.addClass('show-sideBar-SubMenu');
		}
	});
	$('.btn-menu-dashboard').on('click', function(e){
		e.preventDefault();
		var body=$('.dashboard-contentPage');
		var sidebar=$('.dashboard-sideBar');
		if(sidebar.css('pointer-events')=='none'){
			body.removeClass('no-paddin-left');
			sidebar.removeClass('hide-sidebar').addClass('show-sidebar');
		}else{
			body.addClass('no-paddin-left');
			sidebar.addClass('hide-sidebar').removeClass('show-sidebar');
		}
	});

	/*Funcion para enviar datos de formularios*/
    $('.btnFormsAjax').on('click',function(e){
    	e.preventDefault();
        var formId="#"+$(this).attr('data-id');
        var formAction=$(this).attr('data-action');

        if(formAction=="logout"){
            var alertTitle="¿Quieres salir del sistema?";
            var alertText="La sesión actual se cerrará y saldrás del sistema";
            var alertType="question";
            var alertConfirmB= "Si, salir";
        }else if(formAction=="delete"){
            var alertTitle="¿Quieres eliminar el registro?";
            var alertText="El registro se eliminará del sistema y no podrás recuperarlo";
            var alertType="warning";
            var alertConfirmB= "Si, eliminar";
        }else if(formAction=="delcomment"){
        	var alertTitle="¿Quieres eliminar el comentario?";
            var alertText="Tu comentario será eliminado al igual que el archivo adjunto y no podrás recuperarlo";
            var alertType="warning";
            var alertConfirmB= "Si, eliminar";
        }else if(formAction=="delatt"){
            var alertTitle="¿Quieres eliminar el adjunto?";
            var alertText="El archivo adjunto será eliminado y no podrás recuperarlo";
            var alertType="warning";
            var alertConfirmB= "Si, eliminar";
        }else{
            var alertTitle="¿Estás seguro?";
            var alertText="Quieres ejecutar la operación solicitada";
            var alertType="warning";
            var alertConfirmB= "Si, ejecutar";
        }

        swal({
            title: alertTitle,   
            text: alertText,   
            type: alertType,   
            showCancelButton: true,     
            confirmButtonText: alertConfirmB,
            cancelButtonText: "No, cancelar"
        }).then(function () {
            $(formId).submit();
        });
    });

    /*Funcion para enviar datos de formularios con ajax*/
    $('.ajaxDataForm').submit(function(e){
        e.preventDefault();
        var formProcess=$(this).children('.form-process');
        var formType=$(this).attr('data-form');
        var form=$(this);
        var formdata=false;
        var formAction=$(this).attr('action');
        if (window.FormData){
            formdata = new FormData(form[0]);
        }
 		
 		var alertText;
        if(formType==="AddComent"){
        	alertText="Quieres agregar un comentario a esta clase";
        }else if(formType==="AddVideo"){
            alertText="Quieres agregar la clase al sistema";
        }else if(formType==="DellVideo"){
            alertText="Al eliminar la clase del sistema ten en cuenta que también todos los comentarios y archivos adjuntos asociados a la clase se eliminaran";
        }else if(formType==="UpdateVideo"){
            alertText="Los datos de la clase se actualizarán al realizar la operación  solicitada";
        }else{
        	alertText="Quieres realizar la operación solicitada, una vez realizada la operación no se podrá revertir";
        }

        var metodo=form.attr('method');
        var msjErrorAlert="<script>swal('Ocurrió un error inesperado','Por favor recargue la página','error');</script>";
        swal({
            title: "¿Estás seguro?",   
            text: alertText,   
            type: "warning",   
            showCancelButton: true,     
            confirmButtonText: "Si, aceptar",
            cancelButtonText: "No, cancelar"
        }).then(function () {
            $.ajax({
                type: metodo,
                url: formAction,
                data: formdata ? formdata : form.serialize(),
                cache: false,
                contentType: false,
                processData: false,
                xhr: function(){
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                      if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        if(percentComplete<100){
                        	formProcess.html('<p class="text-center">Procesado... ('+percentComplete+'%)</p><div class="progress progress-striped active"><div class="progress-bar progress-bar-info" style="width: '+percentComplete+'%;"></div></div>');
                      	}else{
                      		formProcess.html('<p class="text-center"></p>');
                      	}
                      }
                    }, false);
                    return xhr;
                },
                success: function (data) {
                    formProcess.html(data);
                },
                error: function() {
                    formProcess.html(msjErrorAlert);
                }
            });
            return false;
        });
    });

});