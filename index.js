$(function(){
    var USERNAME=localStorage.getItem('USERNAME');
    USERNAME = USERNAME.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
    });
    var NIK=localStorage.getItem('NIK');
    var USER_ID=localStorage.getItem('USER_ID');
    var KODE_KANTOR=localStorage.getItem('KODE_KANTOR');
    var KODE_AREA=localStorage.getItem('KODE_AREA');

    var hTbl = parseInt($(window).innerHeight())-parseInt($('.navbar-fixed-top').height())-parseInt($('.navbar-fixed-bottom').height())+7;
    var $ex=$('#menu_aplikasi').find('.active');

    if(NIK==""){
        $('#photo_profil').attr('style','width:60px;height:60px;');
        $('#photo_profil').attr('src',"http://103.234.254.186/foto_profil/not-photo.jpg");
    }else{
        $('#photo_profil').attr('style','width:60px;height:60px;');
        $('#photo_profil').attr('src',"http://103.234.254.186/foto_profil/"+NIK+".jpg");
    }

    $('#photo_profil_2').attr('style','width:45px;height:45px;');
    $('#photo_profil_2').attr('src',"http://103.234.254.186/foto_profil/"+NIK+".jpg");
    $('#nama_user').html('<h2>'+USERNAME+'</h2>');

    $('.right_col').css('min-height',hTbl+20);
    $('#pp').css({height : hTbl});

    $(document).on("click", "a.list-group-item.menu-kiri", function(e){
        try{
            var $this=$(this);
            var class_name_array=$this.attr('class').replace('active').trim().split(' ');
            var isPath=$this.data('path');
            var url=class_name_array[class_name_array.length-1];
            var isActive=$this.hasClass('active');
            if(isActive) return;
            var $ex=$('#menu_aplikasi').find('.active');
            $ex.removeClass('active');
            $this.addClass('active');
            var dataTable="path="+isPath+"&url="+url;

            $('#pp').panel({
                'href': isPath+'/'+url,
                onLoad: function(){}
            });
        }catch(e){
            alert(e);
        }
    });

    if(localStorage.getItem('KODE_AREA')=="" || USERNAME=="" || USERNAME=="null"){
        location.href = 'logout.php';
    }

    $.ajax({
        type: "POST",
        url: "__json_data/data_notifikasi.php",
        data: "username="+USERNAME+"&user_id="+USER_ID+"&kode_kantor="+KODE_KANTOR+"&kode_area="+KODE_AREA+"&nik="+NIK,
        cache: false,
        dataType : 'json',
        success: function(data){
            $("abbr.timeago").timeago();
            var data_rows = JSON.parse(JSON.stringify(data.rows));
            var ol = [];
            $('#total_notifikasi').html(data.total);
            $.each(data_rows,function(i,obj){
                var waktu_update=obj.last_update;
                $('#menu1').prepend('<li><a onclick="viewNotification('+obj.id+')"><span class="image"><img src="http://103.234.254.186/foto_profil/'+obj.nik+'.jpg" alt="Profile Image" /></span><span><span><i style="font-size:11px;"><b>'+obj.nama+'</b></i></span><span class="time"><abbr class="timeago" title="'+waktu_update+'">'+waktu_update+'</abbr></span></span><span class="message">'+obj.subject+'</span></a></li>');
            });
            $("abbr.timeago").timeago();
        }
    });
});

function viewNotification(id){
    $('body').find('#dialog-notification').remove();
    $('<div/>').attr('id','dialog-notification').appendTo($('body')).dialog({
        href : "popup/notification.php",
        width : 500,
        height : 'auto',
        position : 'center',
        top : 40,
        title : "Detail ",
        modal:true,
        queryParams : {
            id : id
        },
        method : 'POST',
        onBeforeLoad : function (){
          try {
              delete onLoad.form;
          } catch(e){}
        },
        onLoad : function (){},
        buttons: [{
            text:'Close',
            iconCls:'icon-cancel',
            handler:function(){
                window.location.reload();
            }
        }]
    });
}

function AllViewNotifications(){
    var user_id=localStorage.getItem('USER_ID');
    $('body').find('#dialog-all-notification').remove();
    $('<div/>').attr('id','dialog-all-notification').appendTo($('body')).dialog({
        href : "popup/all_notification.php",
        width : 700,
        height : '500',
        position : 'center',
        title : "Notification",
        modal:true,
        queryParams : {
            user_id :  user_id
        },
        method : 'POST',
        onBeforeLoad : function (){
          try {
              delete onLoad.form;
          } catch(e){}
        },
        onLoadSuccess : function (){

        },
        buttons: [{
            text:'Close',
            iconCls:'icon-cancel',
            handler:function(){
                window.location.reload();
            }
        }]
    });
}

function myformatter(date){
    var y = date.getFullYear();
    var m = date.getMonth()+1;
    var d = date.getDate();
    return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
}

function myparser(s){
    if (!s) return new Date();
    var ss = (s.split('-'));
    var y = parseInt(ss[0],10);
    var m = parseInt(ss[1],10);
    var d = parseInt(ss[2],10);
    if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
        return new Date(y,m-1,d);
    } else {
        return new Date();
    }
}

function myformattermonth(date){
    var y = date.getFullYear();
    var m = date.getMonth()+1;
    return y+'-'+(m<10?('0'+m):m);
}

function myparsermonth(s){
    if (!s) return new Date();
    var ss = (s.split('-'));
    var y = parseInt(ss[0],10);
    var m = parseInt(ss[1],10);
    if (!isNaN(y) && !isNaN(m)){
        return new Date(y,m-1);
    } else {
        return new Date();
    }
}

function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split	= number_string.split(','),
        sisa 	= split[0].length % 3,
        rupiah 	= split[0].substr(0, sisa),
        ribuan 	= split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}
