// EMS Post By Host-1gb.com

$(document).ready(function(e) {
	page = 1;
	
	$("#backtotop").click(function(e) {
		e.preventDefault();
        $("body").animate({scrollTop:0}, 800);
    });
	
	$("#print-agreement").click(function(e) {
        $("#agreement").print();
    });
	
	$("#form-contact").submit(function(e){
		e.preventDefault();
		var submit = $(this).find(":submit");
		submit.button("loading");
		$.post("ajax/mail.contact.php", $(this).serialize(), function(data){
			if (!data.error){
				window.alert("ระบบได้ส่งเรื่องของท่านผ่านทางอีเมล์แล้ว เจ้าหน้าที่จะตอบปัญหาของท่านทางอีเมล์โดยเร็วที่สุด");
				window.location.reload();
			}
			else
				window.alert(data.msg);
			submit.button("reset");
		}, "json");
	});
	
	$("#user_register_form").submit(function(e) {
        e.preventDefault();
		form = $(this);
		var submit = $(this).find(":submit");
		submit.button("loading");
		if ($(this).find("#password").val() != $(this).find("#re-password").val()){
			window.alert("รหัสผ่าน และยืนยันรหัสผ่านไม่ตรงกัน");
			submit.button("reset");
			return false; 
		}
		$.post("ajax/member.registe.php", $(this).serialize(), function(data){
			if (!data.error){
				window.alert("สมัครสมาชิกสำเร็จ");
				$("#RegisterModal").modal("hide");
				$("#LoginModal").modal("show");
				form[0].reset();
			}
			else
				window.alert(data.msg);
			submit.button("reset");
		}, "json");
    });
	
	$("#user_login_form").submit(function(e) {
        e.preventDefault();
		form = $(this);
		var submit = $(this).find(":submit");
		submit.button("loading");
		$.post("member.login.php", $(this).serialize(), function(data){
			if (!data.error){
				form[0].reset();
				window.alert("เข้าสู่ระบบสำเร็จ");
				window.location.reload();
			}
			else
				window.alert(data.msg);
			submit.button("reset");
		}, "json");
    });
	
	$("#email-edit").click(function(e) {
        $(this).popover({ placement: 'bottom', content: 'แจ้งความประสงค์ต้องการแก้ไขอีเมล์ ผ่านทางเมนูติดต่อเรา' });
    });
	
	$("#invoice-print").click(function(e) {
        $(".box-invoice-3").print();
    });
	
	$(".invoice-del").click(function(e) {
        var id = $(this).attr("data-id");
		var submit = $(this);
		submit.button("loading");
		$.post("ajax/invoice.remove.php",{ id: id }, function(data){
			submit.button("reset");
			if (!data.error){
				submit.parents("tr").fadeOut(400, function(){ $(this).remove(); });
			}
			else
				window.alert(data.msg);
		}, "json");
    });
	
	$("#page-load").click(function(e) {
		var btn = $(this);
		btn.button("loading");
        page++;
		$.get("ajax/ems.page.php", { page: page }, function(data){
			btn.button("reset");
			if (!data.error){
				var ems = data.ems;
				for (var i=0;i<ems.length;i++){
					var html = '';
					html += "<tr>\n";
					html += "<td class=\"text-center\" style=\"vertical-align:middle;\">#" + ems[i]["id"] + "</td>\n";
					html += "<td class=\"text-center\" style=\"vertical-align:middle;\">" + ems[i]["barcode"] + "</td>\n";
					html += "<td class=\"text-center\" style=\"vertical-align:middle;\">" + ems[i]["lateststatus"] + "</td>\n";
					html += "<td class=\"text-center\" style=\"vertical-align:middle;\">" + ems[i]["time"] + "</td>\n";
					html += "<td class=\"text-center\" style=\"vertical-align:middle;\">" + ems[i]["updata"] + "</td>\n";
					html += "<td class=\"text-center\" style=\"vertical-align:middle;\">\n";
					html += "<a href=\"?a=detail&id=" + ems[i]["id"] + "\" class=\"btn btn-info btn-xs\">รายละเอียด</a>\n";
					html += "<button class=\"btn btn-danger btn-xs\" onClick=\"ems_del(" + ems[i]["id"] + ", $(this));\" data-loading-text=\"<span class='glyphicon glyphicon-refresh rotate-infinite'></span> รอซักครู่...\"><span class=\"glyphicon glyphicon-remove\"></span> ยกเลิก</button>\n";
					html += "</td>\n";
					$("#table-data").append(html);
				}
				if (data.next == -1)
					btn.parents("tr").fadeOut(400, function(){ $(this).remove(); });
			}else{
				window.alert(data.msg);
				page--;
			}
		}, "json");
    });
	
	$("#alert-email").click(function(e) {
        if ($(this).is(":checked"))
			$("#alert-email-address").enable();
		else
			$("#alert-email-address").disable();
    });
	
	$("#alert-phone").click(function(e) {
        if ($(this).is(":checked"))
			$("#alert-phone-sms").enable();
		else
			$("#alert-phone-sms").disable();
    });
	
	$("#ems-add").submit(function(e) {
        e.preventDefault();
		alert_return = $(this).find("#alert-return");
		var submit = $(this).find(":submit");
		submit.button("loading");
		var barcode = $(this).find("#barcode").val();
		$.post("ajax/ems.add.php", $(this).serialize(), function(data){
			submit.button("reset");
			if (!data.error){
				alert_return.html("<div class=\"alert alert-success\">" + barcode + " ได้เพิ่มลงระบบแล้ว</div>");
				$("#ems-add")[0].reset();
			}
			else
				alert_return.html("<div class=\"alert alert-danger\">" + data.msg + "</div>");
		}, "json");
    });
	
	$("#ems-add").bind("reset", function(e) {
		$("#alert-phone-sms, #alert-email-address").disable();
	});
	
	$("#add-ems-csv").ajaxForm({
		dataType:  'json',
		beforeSubmit: function(){
			alert_return = $("#add-ems-csv").find("#alert-return");
			submit = $("#add-ems-csv").find(":submit");
			submit.button("loading");
		},
		success: function(data){
			submit.button("reset");
			if (!data.error){
				alert_return.html("<div class=\"alert alert-success\">เพิ่มลงระบบแล้ว</div>");
				$("#add-ems-csv")[0].reset();
			}
			else
				alert_return.html("<div class=\"alert alert-danger\">" + data.msg + "</div>");
		}
    });
	
	$("#ems-add").submit(function(e) {
        e.preventDefault();
		if (!IsBarcode($("#barcode").val()))
			alert("รูปแบบหมายเลขพัสดุไม่ถูกต้อง");
    });
	
	$("#barcode").keyup(function(e) {
		$(this).val($(this).val().toUpperCase());
		var has = 'has-warning';
        if (IsBarcode($(this).val()))
			has = 'has-success';
		else
			has = 'has-error';
		$(this).parents(".form-group").removeClass('has-warning').removeClass('has-success').removeClass('has-error').addClass(has);
    });
});

function ems_del(id, submit){
	submit.button("loading");
	$.post("ajax/ems.remove.php",{ id: id }, function(data){
		submit.button("reset");
		if (!data.error){
			submit.parents("tr").fadeOut(400, function(){ $(this).remove(); });
		}
		else
			window.alert(data.msg);
	}, "json");
}

(function($)  {
	$.fn.disable = function() {
		return this.attr('disabled', true);
	}
	$.fn.enable = function() {
		return this.attr('disabled', false);
	}
})(jQuery);