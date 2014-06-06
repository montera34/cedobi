<form id="archivo-search" action="<?php echo CEDOBI_BLOGURL ?>" method="get" role="form">
	<div class="form-group has-feedback">
		<label class="sr-only" for="s">Buscar</label>
		<input type="text" class="form-control" id="s" name="s" placeholder="" />
		<span class="glyphicon glyphicon-search form-control-feedback"></span>
	</div>

	<div class="form-group">
		<a id="search-advanced-btn" href="#">Avanzada <span class="caret"></span></a>

		<div id="search-advanced">
			<div class="checkbox">
				<label>
				<input type="checkbox" name="brigadista" /> Brigadistas
				</label>
			</div>
			<div class="checkbox">
				<label>
				<input type="checkbox" name="fotografia" /> Fondos fotográficos
				</label>
			</div>
			<div class="checkbox">
				<label>
				<input type="checkbox" name="documento" /> Recursos digitales
				</label>
			</div>
			<div class="checkbox">
				<label>
				<input type="checkbox" name="noticias" /> Noticias
				</label>
			</div>
			<div class="checkbox">
				<label>
				<input type="checkbox" name="publicacion" /> Publicaciones
				</label>
			</div>
			<input type="submit" class="form-control" id="submit" name="submit" value="Buscar" />
		</div>
	</div>
</form><!-- #archivo-search -->
