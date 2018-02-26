

$('#cus_input').hide();

$('#checkboxx').change(function(){
	var check = document.getElementById('checkboxx').checked;
	$('#cus_input').slideDown(350);
	if (check == true) {
		$('#tocsv').hide(200);
		$('#no_users').removeClass('disabled');
		$('#starting_range').removeClass('disabled');
		$('#end_range').removeClass('disabled');
	}
	else{
		$('#no_users').addClass('disabled');
		$('#starting_range').addClass('disabled');
		$('#end_range').addClass('disabled');
		$('#cus_input').slideUp(200);
		$('#tocsv').show(200);
	}
	$('#num_users').val('');
});
	


$('#results').hide();

	$(document).ready(function(){
		$.ajax({
			type: 'POST',
			data: {},
			url: 'database/check_db_rows.php',
			success:function(ress){
				if (ress == "1") {
	      			$('#btnUpload').addClass('disabled');
	      			$('#database').attr('disabled',false);
				}
				else{
					$('#database').attr('disabled',true);
					$('#btnLoad').removeClass('disabled');
	      			$('#btnUpload').addClass('disabled');
				}
			}
		});
	});

	var tmp;
	$('#database').change((event)=>{
		$('#btnUpload').removeClass('disabled');
	});

	$('div#btnUpload').on('click',function(){
		$('#database').upload('database/move_database.php',{
	        data: 'database',
	      },function(res){ 
	      	if (res == "success") {
	      		$('#btnLoad').removeClass('disabled');
	      		$('#btnUpload').addClass('disabled');
	      		$('#database').attr('disabled',true);
	      	}
	      	else{

	      	}
	      },function(prog, value){

	      });
	});


	$('img#happiImg').on('click',function(){
		$('#happiImg').transition({
		    debug: true
		  }).transition('scale in').transition('tada', '800ms');
	});

	$('div#btnLoad').on('click',function(){
		$('div#btnLoad').addClass('loading');
		var id = $('#id').val();
		$.ajax({
			type: 'POST',
			data: {id:id},
			url: 'database/get_user.php',
			success:function(res){

				$('.res').html(res);
				$('div#btnLoad').removeClass('loading');
				$('#tocsv').removeClass('disabled');
				$('#results').slideDown(350).delay(4000).slideUp(350);
			}
		});
	});