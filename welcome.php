<div class="row" align="center" >
		<div class="col-md-12" style="overflow:hidden">
				<img width="100%" src="images/welcome.gif" id="welcome">
		</div>
</div>

<script>
		$(function(){
				var hTbl = parseInt($(window).innerHeight())-parseInt($('.navbar-fixed-top').height())-parseInt($('.navbar-fixed-bottom').height())-50;
				$('#welcome').css({ height : hTbl});
		});
</script>
