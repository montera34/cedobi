<?php
$s_query = get_search_query();
if ( $s_query != '' ) { $search_active = " active"; }
?>
<form id="archivo-search" action="<?php echo CEDOBI_BLOGURL ?>" method="get" role="form">
	<div id="search-basic" class="form-group has-feedback<?php echo $search_active ?>">
		<label class="sr-only" for="s">Buscar</label>
		<input type="text" class="form-control" id="s" name="s" placeholder="<?php echo $s_query ?>" />
		<span class="glyphicon glyphicon-search form-control-feedback"></span>
	</div>

	<div id="search-advanced-btn" class="form-group">
		<a href="#">Avanzada <span class="caret"></span></a>
	</div>

	<div id="search-advanced">
	<div class="form-group">
		<select class="form-control" name="post_type">
			<option value="">Archivo completo</option>
			<option value="brigadista">Brigadistas</option>
			<option value="fotografia">Fondos fotográficos</option>
			<option value="documento">Recursos digitales</option>
			<option value="noticia">Noticias</option>
			<option value="convocatoria">Convocatorias</option>
			<option value="publicacion">Publicaciones</option>
		</select>
	</div>
	<div class="form-group">
		<input class="btn" type="submit" class="form-control" id="submit" value="Buscar" />
	</div>
	</div>
</form><!-- #archivo-search -->
