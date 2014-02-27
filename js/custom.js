$(document).ready(function(){
	$('#redes>ul li a').click(function(){
		capaId = $(this).attr('href');
		$('#redes>div').each(function(){
			$this = $(this);
			if( $this.is(capaId) ){
				$this.show();
			} else {
				$this.hide();
			}
		})
		return false;
	})

})