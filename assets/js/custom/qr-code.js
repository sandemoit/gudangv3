$(document).ready(function () {

	let scanned = '';
    
    setInterval(function () {
        var date = new Date();
        var h = date.getHours(), m = date.getMinutes(), s = date.getSeconds();
        h = ("0" + h).slice(-2);
        m = ("0" + m).slice(-2);
        s = ("0" + s).slice(-2);

        var time = h + ":" + m + ":" + s;
        $('.live-clock').html(time);
    }, 1000);

    function onScanSuccess(decodedText) {
    	if (scanned !== decodedText) {
			scanned = decodedText;
        	$.ajax({
    			type: 'post',
    			url: '/siswa/validate_qrcode',
    			data: {
    				scanned
    			},
    			success: function(result){
    				// script here if success
                	result = JSON.parse(result);
                
                	let today = new Date();
					let dd = String(today.getDate()).padStart(2, '0');
					let mm = String(today.getMonth() + 1).padStart(2, '0');
					let yyyy = today.getFullYear();
					let hh = String(today.getHours()).padStart(2, '0');
					let ii = String(today.getMinutes()).padStart(2, '0');
					let ss = String(today.getSeconds()).padStart(2, '0');
					let waktu = `${dd}-${mm}-${yyyy} ${hh}:${ii}:${ss}`;
                
                	if (result.result == 'ngawur') {
                    	$('#notif').show().removeClass('alert-success').addClass('alert-danger').html("Materi pembelajaran tidak diketahui.");
                	} else if (result.result == true) {
                    	$('#notif').show().removeClass('alert-danger').addClass('alert-success').html("Terimakasih telah melakukan absen pada " + waktu);
                    } else {
                    	$('#notif').show().removeClass('alert-success').addClass('alert-danger').html("Anda sudah melakukan absen.");
                    }
                
    				$('#mapel').html(result.data.mapel);
    				$('#guru').html(result.data.guru);
    			}
    		});
        }
    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: 300 }
    );
    html5QrcodeScanner.render(onScanSuccess);
});
