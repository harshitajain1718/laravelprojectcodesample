@extends('user.layouts.app')

@section('title', 'Industry question-answer')

@section('content')

<!-- begin::Body -->
	<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

		<!-- BEGIN: Left Aside -->
		<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>		
		@include('user.layouts.sidebar')

		<div class="m-grid__item m-grid__item--fluid m-wrapper">
			<div class="m-subheader">
				<div class="d-flex align-items-center">
					<div class="mr-auto">
						<h3 class="m-subheader__title">Industry Knowledge</h3>
					</div>
				</div>
			</div>
			
			<div class="m-content hotels-page">
				<div class="breadcrumb">
					<ul class="clearfix">
						<li>
							<a href="{{route('user.dashboard')}}">Dashboard</a>
						</li>
						<li>
							<a href="{{route('user.category.industry.index')}}">Industry Knowledge</a>
						</li>
						<li>
							<span>@if(isset($catdata->name)){{$catdata->name}}@endif</span>
						</li>
					</ul>
					<div class="do-the-test-btn-right">
					<form action="{{ route('industry.test.dotest') }}" method="post">
						 <input type="hidden" name="_token" value="{{csrf_token()}}">
						 <input type="hidden" name="category" value="{{$cat_id}}">
						 <button type="submit" name="start_test" id="start_test" class="btn btn-primary">Do Test</button>
					</form>
					</div>
					
				</div>
				<!-- display question with location details and questions -->
				<div class="main_hotels">
					<?php
						$viewques= 'Enable';
						$category_id = $cat_id;
						$user_id= Session::get('user_id');
						$exam_type= Session::get('exam_type_'.$user_id);
        				$exam_cat= Session::get('exam_cat_'.$user_id);
        				if(isset($exam_cat)){
        					if($exam_cat==$category_id){
				                $viewques= 'Disable';
				            } 
				        }
					?>
					@if($viewques=='Enable')
						<div class="row">
						   	<?php $i=0; ?>
						   	@if(!empty($data))
							@foreach($data as $cat_ques)
							<?php  $i++; ?>
								<div class="col-xl-4 col-md-6 col-sm-12">
									   <a class="btn" href="javascript:void(0);" style="background-color: {{$color}}">{{'Question '.$i}}</a>
						         	<div class="box" style="background: {{$color}}">
						            	<h5>Q.</h5>
						            	<p id="ques_{{$cat_ques->id}}">{{$cat_ques->question}}</p>
							            <div class="view-answer">
							               <button type="button" class="btn btn-light" data-toggle="collapse" data-target="#collapse{{$i}}" aria-expanded="false">View Answer</button>
							            </div>
							            <div class="collapse" id="collapse{{$i}}" style="">
											<article class="card-body">
												<h5>A.</h5>
												<p id="ans_{{$cat_ques->id}}" style="text-align: left;" class="area-knowlege-title">{{$cat_ques->answer}}</p>
											</article> 
										</div> 
						         	</div>
						      </div>
							@endforeach
							@else
					 			<i>No any questions created for this chapter.</i>
							@endif
		                </div>
	               	@else
	               		<span class="cat_error_div"> Yor are currently unable to view answers</span>
	               	@endif
				</div>
				<div class="do-the-test-btn-bottom">
						<form action="{{ route('industry.test.dotest') }}" method="post">
						 <input type="hidden" name="_token" value="{{csrf_token()}}">
						 <input type="hidden" name="category" value="{{$cat_id}}">
						 <button type="submit" name="start_test" id="start_test" class="btn btn-primary">Do Test</button>
					</form>
				</div>
			</div>
		</div>
	</div>

 @if ($errors->any())
	        <script type="text/javascript">
	            @foreach ($errors->all() as $error)
	            setTimeout(function() {
	                toastr.options = {
	                    closeButton: true,
	                    progressBar: true,
	                    showMethod: 'slideDown',
	                    timeOut: 4000
	                };
	                toastr.error('<?php echo $error; ?>');
	            }, 1300);
	            @endforeach
	        </script>
	    @endif

	    @if ($message = Session::get('succ_message'))
	    <script type="text/javascript">
	    setTimeout(function() {
	        toastr.options = {
	            closeButton: true,
	            progressBar: true,
	            showMethod: 'slideDown',
	            timeOut: 4000
	        };
	        toastr.success('{{$message["msg"]}}');
	    }, 1300);
	    </script>
	    @endif

	    @if ($message = Session::get('err_message'))
	    <script type="text/javascript">
	    setTimeout(function() {
	        toastr.options = {
	            closeButton: true,
	            progressBar: true,
	            showMethod: 'slideDown',
	            timeOut: 4000
	        };
	        toastr.error('{{$message["msg"]}}');
	    }, 1300);
	    </script>
	    @endif


<script type="text/javascript">
$(document).on('click','#start_test',function(){
	setInterval(function(){
			$.ajax({
				url: "{{route('user.get_session_data')}}", 
				type:"POST",
				data:{'_token':"{{csrf_token()}}",'cat_id':"{{$cat_id}}"}, 
				success: function(result){
					if(result=='Disable'){
						$('.row').html('');
                		$('.main_hotels').html('<span class="cat_error_div"> Yor are currently unable to view answers</span>');
					}
				}
			});
		 }, 3000);
	/*geolocation on map with pin*/
	function showLocation() {
        var input1 = document.getElementById('option1');
        var autocomplete = new google.maps.places.Autocomplete(input1, {
            types: ["geocode"]
        });

        var input2 = document.getElementById('option2');
        var autocomplete = new google.maps.places.Autocomplete(input2, {
            types: ["geocode"]
        });

        var input3 = document.getElementById('option3');
        var autocomplete = new google.maps.places.Autocomplete(input3, {
            types: ["geocode"]
        });

        var input4 = document.getElementById('option4');
        var autocomplete = new google.maps.places.Autocomplete(input4, {
            types: ["geocode"]
        });
    }

    /*update details based on answer given by user*/
    $(document).on('click','.answer', function(){
    	var option_id = $(this).data('id');
    	var answer = $('#'+option_id).val();
    	if(answer){
    		$('.errorAnswer').css('display','none');

    		var geocoder = new google.maps.Geocoder();
			geocoder.geocode( { 'address': answer}, function(results, status) {
			  if (status == google.maps.GeocoderStatus.OK) {
			    var latitude = results[0].geometry.location.lat();
			    var longitude = results[0].geometry.location.lng();
			    alert(latitude);
			    alert(longitude);
			  } 
			});

	    	var input = document.getElementById('option1');
	        var autocomplete = new google.maps.places.Autocomplete(input, {
	            types: ["geocode"]
	        });

	        google.maps.event.addListener(autocomplete, 'place_changed', function() {
	          var place = autocomplete.getPlace();
	          // console.log(place.geometry);
	          var lat = place.geometry.location.lat();
	          var lng = place.geometry.location.lng();
	          var placeId = place.place_id;
	          document.getElementById("latitude").value = lat.toFixed(4);
	          document.getElementById("longitude").value = lng.toFixed(4);
	        });
    	}else{
    		$(this).prop('checked', false);
    		$('.errorAnswer').text('Please enter option value first.');
    		$('.errorAnswer').css('display','block');
    		/*validator.focusInvalid();*/
    	}
    	
    });

    /*check validation for Eircode (Ireland)*/
    function validateEircode(eircode) {
        var pattern = 
                '\\b(?:(' +
                'a(4[125s]|6[37]|7[5s]|[8b][1-6s]|9[12468b])|' +
                'c1[5s]|' +
                'd([0o][1-9sb]|1[0-8osb]|2[024o]|6w)|' +
                'e(2[15s]|3[24]|4[15s]|[5s]3|91)|' +
                'f(12|2[368b]|3[15s]|4[25s]|[5s][26]|9[1-4])|' +
                'h(1[2468b]|23|[5s][34]|6[25s]|[79]1)|' +
                'k(3[246]|4[5s]|[5s]6|67|7[8b])|' +
                'n(3[79]|[49]1)|' +
                'p(1[247]|2[45s]|3[126]|4[37]|[5s][16]|6[17]|7[25s]|[8b][15s])|' +
                'r(14|21|3[25s]|4[25s]|[5s][16]|9[35s])|' +
                't(12|23|34|4[5s]|[5s]6)|' +
                'v(1[45s]|23|3[15s]|42|9[2-5s])|' +
                'w(12|23|34|91)|' +
                'x(3[5s]|42|91)|' +
                'y(14|2[15s]|3[45s])' +
                ')\\s?[abcdefhknoprtsvwxy\\d]{4})\\b';
        
        var reg = new RegExp(pattern, 'i');
        //return the first Eircode
        var i = String(eircode).search(reg);
        if (i!=-1)
          return(String(eircode).substring(i,i+8).toUpperCase().replace(' ', '').replace(/O/g, 0).replace(/S/g, 5).replace(/B/g, 8));
        else                  
            return "";
    }
    $(document).ready(function(){
        
        $.validator.addMethod("eircode", function(value, element) {
            if(value != '')
            {
                if (/^\b(?:(a(4[125s]|6[37]|7[5s]|[8b][1-6s]|9[12468b])|c1[5s]|d([0o][1-9sb]|1[0-8osb]|2[024o]|6w)|e(2[15s]|3[24]|4[15s]|[5s]3|91)|f(12|2[368b]|3[15s]|4[25s]|[5s][26]|9[1-4])|h(1[2468b]|23|[5s][34]|6[25s]|[79]1)|k(3[246]|4[5s]|[5s]6|67|7[8b])|n(3[79]|[49]1)|p(1[247]|2[45s]|3[126]|4[37]|[5s][16]|6[17]|7[25s]|[8b][15s])|r(14|21|3[25s]|4[25s]|[5s][16]|9[35s])|t(12|23|34|4[5s]|[5s]6)|v(1[45s]|23|3[15s]|42|9[2-5s])|w(12|23|34|91)|x(3[5s]|42|91)|y(14|2[15s]|3[45s]))\s?[abcdefhknoprtsvwxy\d]{4})\b$/i.test( value ) || value == 'Ireland' || value == 'ireland') {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return true;
            }
            
        }, "Please specify a valid Eircode.");

    });

    /*read more functionality*/
	$(".readmore").on('click', function(event) {
        var txt = $(".more-content").is(':visible') ? 'Show more' : '';
        $(this).parent().prev(".more-content").toggleClass("cg-visible");
        $(this).html(txt);
        event.preventDefault();
    });
</script>
@stop












