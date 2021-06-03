$(document).ready(function(e) {




	var ad,soyad,mail,telefon;


	$('.Bilgitercih input[name="bilgiTercih"]').on('change',function() {



		var gelenTercih=$(this).val(); // 0-1

		if (gelenTercih==1)
		{
			ad=$('input[id=sipAd]').val();
			soyad=$('input[id=sipSoyad]').val();
			mail=$('input[id=sipMail]').val();
			telefon=$('input[id=sipTlf]').val();


			$('input[id=sipAd]').val("");
			$('input[id=sipSoyad]').val("");
			$('input[id=sipMail]').val("");
			$('input[id=sipTlf]').val("");

		}

		else {

			$('input[id=sipAd]').val(ad);
			$('input[id=sipSoyad]').val(soyad);
			$('input[id=sipMail]').val(mail);
			$('input[id=sipTlf]').val(telefon);

		}


	});


	/* SMS İŞLEMLERİ İÇİN GRUPLAR VE ŞABLONLAR */

	// GRUPLAR İLE İLGİLİ KODLAR

	$('#gruplar select').on('change',function() {

		var secilendeger= $(this).val();
		var grupad = $(this).children('option:selected').attr("data-value");
		var tabload = $(this).attr("data-value");


		if (grupad!=null) {

			$('#grupislem').html('<div class="row"><div class="col-lg-8 col-xl-8 col-md-8 col-sm-8"><form id="grupguncelle"><input name="grupad" class="form-control" value="'+grupad+'"><input name="grupid" type="hidden" value="'+secilendeger+'"><input name="tabload" type="hidden" value="'+tabload+'"></div><div class="col-lg-2 col-xl-2 col-md-2 col-sm-2"><input type="button" id="grupguncelbtn" class="btn btn-success btn-sm mt-1" value="Güncelle"></form></div><div class="col-lg-2 col-xl-2 col-md-2 col-sm-2"><input type="button" class="btn btn-danger btn-sm mt-1" id="grupsilbtn" value="Sil" data-value="'+secilendeger+'" data-value2="'+tabload+'"></div></div>');


		}
		else {
			$('#grupislem').html('İŞLEM SEÇİNİZ');

		}


	});





	$(document).on("click","#grupguncelbtn",function() {

		$.ajax({
			type:"POST",
			url:'http://localhost/PROJELER/mvcproje/GenelGorev/grupadguncelle',
			data:$('#grupguncelle').serialize(),
			success: function(donen_veri){
				$('#grupguncelle').trigger("reset");

				$('#grupislem').html(donen_veri);


			}
		});



	});

	$(document).on("click","#grupsilbtn",function() {

		var id=$(this).attr('data-value');
		var tabload=$(this).attr('data-value2');

		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/grupadsil",{"grupid":id,"tabload":tabload},function(donen) {

			$('#grupislem').html(donen);

		});



	});


	$("#grupekle").on("click",function() {
		var tabload = $(this).attr("data-value");

		$('#grupislem').html('<div class="row"><div class="col-lg-8 col-xl-8 col-md-8 col-sm-8"><form id="grupekleform" name="ekleme"><input name="grupad" type="text" class="form-control"><input name="tabload" type="hidden" value="'+tabload+'"></div><div class="col-lg-4 col-xl-4 col-md-4 col-sm-4"><input type="button" id="grupeklebtn" class="btn btn-success btn-sm mt-1 btn-block" value="Ekle"></form></div></div>');


	});


	$(document).on("click","#grupeklebtn",function() {

		$.ajax({
			type:"POST",
			url:'http://localhost/PROJELER/mvcproje/GenelGorev/grupekleme',
			data:$('#grupekleform').serialize(),
			success: function(donen_veri){
				$('#grupekleform').trigger("reset");

				$('#grupislem').html(donen_veri);

			}
		});



	});



	// GRUPLAR İLE İLGİLİ KODLAR


	// ŞANLONLAR İLE İLGİLİ KODLAR

	$('#sablonlar select').on('change',function() {

		var secilendeger= $(this).val();
		var sablonad = $(this).children('option:selected').attr("data-value");
		var sablonicerik = $(this).children('option:selected').attr("data-value2");
		var tabload = $(this).attr("data-value");
		if (sablonad!=null) {

			$('#sablonislem').html('<div class="row"><div class="col-lg-8 col-xl-8 col-md-8 col-sm-8"><form id="sablonguncelleform"><input name="sablonad" class="form-control" value="'+sablonad+'"><input name="sablonid" type="hidden" value="'+secilendeger+'"><input name="tabload" type="hidden" value="'+tabload+'"><textarea class="form-control mt-2" rows="8" name="sablonicerik">'+sablonicerik+'</textarea></div><div class="col-lg-2 col-xl-2 col-md-2 col-sm-2"><input type="button" id="sablonguncelbtn" class="btn btn-success btn-sm mt-1" value="Güncelle"></form></div><div class="col-lg-2 col-xl-2 col-md-2 col-sm-2"><input type="button" class="btn btn-danger btn-sm mt-1" id="sablonsilbtn" value="Sil" data-value="'+secilendeger+'" data-value2="'+tabload+'"></div></div>');


		}
		else {
			$('#sablonislem').html('İŞLEM SEÇİNİZ');

		}


	});





	$(document).on("click","#sablonguncelbtn",function() {

		$.ajax({
			type:"POST",
			url:'http://localhost/PROJELER/mvcproje/GenelGorev/sablonguncelle',
			data:$('#sablonguncelleform').serialize(),
			success: function(donen_veri){
				$('#sablonguncelleform').trigger("reset");

				$('#sablonislem').html(donen_veri);


			}
		});



	});

	$(document).on("click","#sablonsilbtn",function() {

		var id=$(this).attr('data-value');
		var tabload=$(this).attr('data-value2');
		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/sablonsil",{"sablonid":id,"tabload":tabload},function(donen) {

			$('#sablonislem').html(donen);

		});






	});


	$("#sablonekle").on("click",function() {
		var tabload = $(this).attr("data-value");

		$('#sablonislem').html('<div class="row"><div class="col-lg-8 col-xl-8 col-md-8 col-sm-8"><form id="sablonekleform"><input name="sablonad" class="form-control" ><input name="tabload" type="hidden" value="'+tabload+'"><textarea class="form-control mt-2" rows="8" name="sablonicerik"></textarea></div><div class="col-lg-2 col-xl-2 col-md-2 col-sm-2"><input type="button" id="sabloneklebtn" class="btn btn-success btn-sm mt-1" value="EKLE"></form></div></div>');


	});


	$(document).on("click","#sabloneklebtn",function() {

		$.ajax({
			type:"POST",
			url:'http://localhost/PROJELER/mvcproje/GenelGorev/sablonekleme',
			data:$('#sablonekleform').serialize(),
			success: function(donen_veri){
				$('#sablonekleform').trigger("reset");

				$('#sablonislem').html(donen_veri);

			}
		});



	});


	// ŞABLONLAR İLE İLGİLİ KODLAR

	// ŞABLON SEÇME KODLARI

	$('select[name="sablonsec"]').on('change',function() {
		$('textarea[name="metin"]').val("");
		$('textarea[name="metin"]').val($('select[name="sablonsec"] option:selected').attr("data-value"));


	});

	// ŞABLON SEÇME KODLARI
	// GRUP  SEÇME KODLARI

	$('select[name="grupsec"]').on('change',function() {
		var gelenid= $(this).val();
		var sutunad = $(this).attr("data-value");

		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/grupcek",{"grupid":gelenid,"sutunad":sutunad},function(donen) {


			$('textarea[name="mailadresleri"]').append(donen);



		});






	});

	// GRUP  SEÇME KODLARI


	$(document).on("click","#bultenmailgetir",function() {

		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/bultenmailgetir",{"durum":"ok"},function(donen) {


			$('textarea[name="mailadresleri"]').append(donen);



		});



	});

	// TOPLU NUMARA EKLEME KODLARI
	$('.maileklemebilgi').hide();



	$("#maileklebtn").click(function (e){

		e.preventDefault();

	var formData = new FormData($("#toplumailform")[0]);

	$.ajax({
		beforeSend: function () {
			$('.maileklemebilgi').append("Yükleme Başlıyor<br>").show();
		},
		type: "POST",
		url: "http://localhost/PROJELER/mvcproje/GenelGorev/toplumailekleme",
		enctype: 'multipart/formdata',
		processData: false,
		contentType: false,
		data: formData,
	}).done(function (donen_veri) {
		$('#toplumailform').trigger("reset");
		$('.maileklemebilgi').append("Yüklendi<br>");
		$('textarea[name="mailadresleri"]').append(donen_veri);
		$('.maileklemebilgi').html("").hide();
	});
	});




	$(document).ready(function() {
		function BilgiPenceresi(linkAdres,sonucbaslik,sonucmetin,sonuctur) {

			swal(sonucbaslik, sonucmetin, sonuctur, {
				buttons: {

					catch: {
						text: "KAPAT",
						value: "tamam",
					}
				},
			})
				.then((value) => {
					if (value=="tamam") {
						window.location.href =  linkAdres;
					}

				});

		}
	});






	/*kullanıcı arayüz siparis iade*/
	$('body #iade').on('click',function (){

		var eleman=$(this);
		var sipno=$(this).attr('data-value');
		var iadeiskelet=eleman.parents(".arkaplan2").find("#iadeiskelet");

		iadeiskelet.html('<div class="alert alert-info text-center"><button id="iadebutonu" class="btn btn-primary" data-value="'+sipno+'">İade etmek istediğinize emin misiniz?</button></div>');



		iadeiskelet.find('#iadebutonu').click(function() {

			var sipno=$(this).attr('data-value');



			$.post("http://localhost/PROJELER/mvcproje/GenelGorev/iadeislemi",{"sipno":sipno},function(cevap) {


				var iadeiskelet=eleman.parents(".arkaplan2").find("#iadeiskelet");

				iadeiskelet.html(cevap);



			});



		});



	});
	/*kullanıcı arayüz siparis iade*/




	$('#iadeonay a').on('click',function (){

		var eleman=$(this);
		var sipno=$(this).attr('data-value');
		var iadeiskelet=eleman.parents(".arkaplan");


		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/paneliadeislemi",{"sipno":sipno},function() {

			iadeiskelet.fadeOut();

		});

	});
















	$('#anaekranselect').attr("disabled",false);
	$('#cocukekranselect').attr("disabled",true);
	$('#katidekranselect').attr("disabled",true);



	$('#anaekranselect').on('change',function (){

		var secilendeger=$(this).val();
		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/selectkontrol",
			{"kriter":"anaekrancocukgetir","anaid":secilendeger},function(cevap) {
				$('#cocukekranselect').attr("disabled",false);
				$('#cocukekranselect').html(cevap);

			});
		$('#katidekranselect').attr("disabled",true).html('<option value"0">Seçiniz</option>');



	});



	$('#cocukekranselect').on('change',function (){
		$('#katidekranselect').attr("disabled",false);

		var secilendeger=$(this).val();
		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/selectkontrol",
			{"kriter":"anaekrancocukgetir","cocukid":secilendeger},function(cevap) {

				$('#katidekranselect').html(cevap);

			});



	});








	/* ÜRÜN GÜNCELLEME */
	$('#sifirla').on('click',function (){
		$('#anaselect').attr("disabled",false);
		$('#cocukselect').attr("disabled",false).html('<option value"0">Seçiniz</option>');
		$('#altselect').attr("disabled",false).html('<option value"0">Seçiniz</option>');

	});



	$('#anaselect').on('change',function (){

		var secilendeger=$(this).val();
		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/selectkontrol",
			{"kriter":"cocukgetir","anaid":secilendeger},function(cevap) {

			$('#cocukselect').html(cevap);

		});
		$('#altselect').attr("disabled",true).html('<option value"0">Seçiniz</option>');



	});



	$('#cocukselect').on('change',function (){
		$('#altselect').attr("disabled",false);

		var secilendeger=$(this).val();
		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/selectkontrol",
			{"kriter":"altgetir","cocukid":secilendeger},function(cevap) {

			$('#altselect').html(cevap);

		});



	});
	/* ÜRÜN GÜNCELLEME */







	$('#sec').click(function () {
		$('#EklemeformuAna input[type="checkbox"]').attr("checked", true);

	});

	$('#kaldir').click(function () {
		$('#EklemeformuAna input[type="checkbox"]').attr("checked", false);

	});

	$('#sec').click(function () {
		$('#GuncelleformuAna input[type="checkbox"]').attr("checked", true);

	});

	$('#kaldir').click(function () {
		$('#GuncelleformuAna input[type="checkbox"]').attr("checked", false);

	});



	$('#detaygoster #adres').click(function() {

		var sipno=$(this).attr('data-value');
		var adresid=$(this).attr('data-value2');



		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/teslimatgetir",{"sipno":sipno,"adresid":adresid},function(cevap) {

			$(".modal-body").html(cevap);
			$("#exampleModalLongTitle").html("Teslimat adresi ve kişisel bilgiler");

		});



	});



	$('#detaygoster #siparis').click(function() {

		var sipno=$(this).attr('data-value');
		var adresid=$(this).attr('data-value2');



		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/siparisgetir",{"sipno":sipno,"adresid":adresid},function(cevap) {

			$(".modal-body").html(cevap);
			//$("#exampleModalLongTitle").html("Teslimat adresi ve kişisel bilgiler");

		});



	});



	jQuery.fn.extend({
		printElem: function() {
			var cloned = this.clone();
			var printSection = $('#printSection');
			if (printSection.length == 0) {
				printSection = $('<div id="printSection"></div>')
				$('body').append(printSection);
			}
			printSection.append(cloned);
			var toggleBody = $('body *:visible');
			toggleBody.hide();
			$('#printSection, #printSection *').show();
			window.print();
			printSection.remove();
			toggleBody.show();
		}
	});

	$(document).ready(function(){
		$(document).on('click', '#btnPrint', function(){
			$('#exampleModalCenter').printElem();
		});
	});






	$("#aramakutusu").attr("placeholder","Sipariş Numarası");

	$("#aramaselect").on('change', function (e){
		var secilenial = $(this);
		var $valuenindegeri = secilenial.val();



		if ($valuenindegeri=="sipno"){
			$("#aramakutusu").val("");
			$("#aramakutusu").attr("placeholder","Sipariş Numarası");
		}
		if ($valuenindegeri=="uyebilgi"){
			$("#aramakutusu").val("");
			$("#aramakutusu").attr("placeholder","Üye Bilgisi");
		}
	});
	$("#SepetDurum").load("http://localhost/PROJELER/mvcproje/GenelGorev/SepetKontrol");
	
	$("#Sonuc").hide();
	
	$("#FormAnasi").hide();
	
	
    $("#yorumEkle").click(function(e) {
		 $("#FormAnasi").slideToggle();	
        
    });
	
	
	$("#yorumGonder").click(function() {
		
		$.ajax({
			type:"POST",
			url:'http://localhost/PROJELER/mvcproje/GenelGorev/YorumFormKontrol',
			data:$('#yorumForm').serialize(),
			success: function(donen_veri){
				$('#yorumForm').trigger("reset");
				$('#FormSonuc').html(donen_veri);
				
				if ($('#ok').html()=="Yorumunuz kayıt edildi. Onaylandıktan sonra yayınlanacaktır") {
					$("#FormAnasi").fadeOut();
					
					
				}
				
			
				
			},
		});
			
		
        
    });
	
	
	$("[type='number']").keypress(function (evt) {
		evt.preventDefault();
		
		
	});
	
	
	
	
	
	$("#bultenBtn").click(function() {
		
		
	$.ajax({
			type:"POST",
			url:'http://localhost/PROJELER/mvcproje/GenelGorev/BultenKayit',
			data:$('#bultenForm').serialize(),
			success: function(donen_veri){
				$('#bultenForm').trigger("reset");
				$('#Bulten').html(donen_veri);
				
				if ($('#bultenok').html()=="Bultene Başarılı bir şekilde kayıt oldunuz. Teşekkür ederiz") {
				
					
					
				}
				
			
				
			},
		});
			
		
        
    });
	
	
	
	
	
	$("#İletisimbtn").click(function() {
		//$('#iletisimForm').fadeOut();
		
		
//$('#FormSonuc').html("Merhaba");
		
		
	$.ajax({
			type:"POST",
			url:'http://localhost/PROJELER/mvcproje/GenelGorev/iletisim',
			data:$('#iletisimForm').serialize(),
			success: function(donen_veri){
				$('#iletisimForm').trigger("reset");
			$('#FormSonuc').html(donen_veri);
				
					if ($('#formok').html()=="Mesajınız Alındı. En kısa sürede Dönüş yapılacaktır. Teşekkür ederiz") {
						
				$('#iletisimForm').fadeOut();
				$('#FormSonuc').html(donen_veri);
					
					
				}
				
				
							
			
				
			},
		});
			
		
        
    });
	
	
	
		$("#SepetBtn").click(function() {

		
	$.ajax({
			type:"POST",
			url:'http://localhost/PROJELER/mvcproje/GenelGorev/SepeteEkle',
			data:$('#SepeteForm').serialize(),
			success: function(donen_veri){
				$('#SepeteForm').trigger("reset");
				
				
				$("html,body").animate({scrollTop : 0} , "slow");
				
		$("#SepetDurum").load("http://localhost/PROJELER/mvcproje/GenelGorev/SepetKontrol");					
		$('#Mevcut').html('<div class="alert alert-success text-center">SEPETE EKLENDİ</div>');
				
					
							
			
				
			},
		});
			
		
        
    });
	
	
	
	
	
	$('#GuncelForm input[type="button"]').click(function() {
		
		var id=$(this).attr('data-value');
		
		
		var adet=$('#GuncelForm input[name="adet'+id+'"]').val();
		
		
		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/UrunGuncelle",{"urunid":id,"adet":adet},function() {
			
		window.location.reload();
		
	});	
		
		
		
	});
	
	
	//--------------------------------------------------------------------------
	
	
		$('#GuncelButonlarinanasi input[type="button"]').click(function() {
		
		var id=$(this).attr('data-value');
		
		
		var textArea=$("<textarea id='"+id+"' name='yorum' style='width:100% height:200px' />");
		
		
		textArea.val($(".sp"+id).html());
		$(".sp"+id).parent().append(textArea);
		$(".sp"+id).remove();
		input.focus();
		
		
	
		
		
	});
	
	
	$(document).on('blur' ,'textarea[name=yorum]',function() {
		
		$(this).parent().append($('<span/>').html($(this).val()));
		var id=$(this).attr("id");
		$(this).remove();
		
		
		
		
		$.post("http://localhost/PROJELER/mvcproje/uye/YorumGuncelle",{"yorumid":id,"yorum":$(this).val()},function(donen) {
			
			//alert(donen);
			
		window.location.reload();
		
	});		
	
		

		
		
	});
	
	
//---------------------------------------------------------------------------

$('#AdresGuncelButonlarinanasi input[type="button"]').click(function() {
		
		var id=$(this).attr('data-value');
		
		
		var textArea=$("<textarea id='"+id+"' name='adres' style='width:100%; height:100%;' />");
		
		
		textArea.val($(".adresSp"+id).html());
		$(".adresSp"+id).parent().append(textArea);
		$(".adresSp"+id).remove();
		input.focus();
		
	
		
		
	});
	
	
	$(document).on('blur' ,'textarea[name=adres]',function() {
		
		$(this).parent().append($('<span/>').html($(this).val()));
		var id=$(this).attr("id");
		$(this).remove();
		
		
		
		
		$.post("http://localhost/PROJELER/mvcproje/uye/AdresGuncelle",{"adresid":id,"adres":$(this).val()},function(donen) {
			
			//alert(donen);
			
		window.location.reload();
		
	});		
	
		

		
		
	});	
	
	
	
	var ad,soyad,mail,telefon;
	
	
	$('input[name=bilgiTercih]').on('change',function() {
		
	
		
		var gelenTercih=$(this).val(); // 0-1
		
		if (gelenTercih==1) 		
		{
			ad=$('input[id=sipAd]').val();
			soyad=$('input[id=sipSoyad]').val();
			mail=$('input[id=sipMail]').val();
			telefon=$('input[id=sipTlf]').val();
			
			
			 $('input[id=sipAd]').val("");
			 $('input[id=sipSoyad]').val("");
			 $('input[id=sipMail]').val("");
			 $('input[id=sipTlf]').val("");
			
		}
		
		else {
			
			 $('input[id=sipAd]').val(ad);
			 $('input[id=sipSoyad]').val(soyad);
			 $('input[id=sipMail]').val(mail);
			 $('input[id=sipTlf]').val(telefon);	
			
		}
		


		
	
	
		
	});
	

	
	
	

	

	
	
});





function VarsayilanYap(deger,deger2) {

			$.post("http://localhost/PROJELER/mvcproje/GenelGorev/VarsayilanAdresYap", {"uyeid": deger,"adresid": deger2}, function () {


				$.post("http://localhost/PROJELER/mvcproje/GenelGorev/VarsayilanAdresYap2", {"uyeid": deger,"adresid": deger2}, function () {

					window.location.reload();

				});

			});

	}



function uyeyorumkontrol(yorumid,kriter) {


	$.post("http://localhost/PROJELER/mvcproje/GenelGorev/uyeyorumkontrol", {"yorumid": yorumid,"kriter": kriter}, function () {

		window.location.reload();

	});

	}


function UrunSil(deger,kriter) {
	
	switch  (kriter) {
		
		
		case "sepetsil":
		$.post("http://localhost/PROJELER/mvcproje/GenelGorev/UrunSil",{"urunid":deger},function() {
		
		window.location.reload();
		
		});	
		
		
		break;
		
		case "yorumsil":
		
		
		
		$.post("http://localhost/PROJELER/mvcproje/uye/Yorumsil",{"yorumid":deger},function(donen) {
			
			
			
			if (donen)  {				
				$("#Sonuc").html("Yorum başarıyla silindi.");				
			}
			else
			{
				$("#Sonuc").html("Silme işleminde hata oluştu.");
					
			}
		
				$("#Sonuc").fadeIn(1000,function() {
						
						$("#Sonuc").fadeOut(1000,function() {
							$("#Sonuc").html("");
							window.location.reload();				
					
						});
				
				
					
				});
		
		
		
		});	
		
		
		break;
		
		case "adresSil":
		$.post("http://localhost/PROJELER/mvcproje/uye/adresSil",{"adresid":deger},function(donen) {
		
		
			if (donen)  {				
				$("#Sonuc").html("Adres başarıyla silindi.");				
			}
			else
			{
				$("#Sonuc").html("Silme işleminde hata oluştu.");
					
			}
		
				$("#Sonuc").fadeIn(1000,function() {
						
						$("#Sonuc").fadeOut(1000,function() {
							$("#Sonuc").html("");
							window.location.reload();				
					
						});
				
				
					
				});
		
		
		
		
		
		});	
		
		
		break;
		
		
	
	
		
	}
	
	
	
	
	
}


