<div class="row">

						<div class="col-md-6">
							<div class="form-group">
								<label>Nome</label>
								<input type="text" name="nome_produto" class="form-control">
							</div>
						</div>
						<div class="col-md-3 text-center">
							<label>Controlar estoque?</label><br>
							{!! Form::checkbox('tracked', 1) !!}
						</div>
						<div class="col-md-3 text-center">
							<label>Ativo?</label><br>
							{!! Form::checkbox('is_ativo', 1) !!}
						</div>
					</div>

					<div class="row">
						
					
						<div class="col-md-6">
							<div class="form-group">
								<label>Descrição</label>
								<input type="text" name="descricao" class="form-control">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Preço médio</label>
								<input type="text" name="preco" class="form-control money"/>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Categoria</label>
			              		{!! Form::select('categoria_id', $categorias, null, ['class' => 'form-control', 'single' => 'single', 'id' => 'categoria'])   !!}
			        		</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Fornecedores</label>
			              		{!! Form::select('fornecedor_id[]', $fornecedoresForSelect, null, ['class' => 'form-control', 'multiple' => 'multiple', 'id' => 'fornecedores'])   !!}
			        		</div>
						</div>
					</div>

					<div class="row">
					
						<hr line-height="3px" />

						<div class="col-md-12">
							<p>Caso este produto seja venda direta, preencha os campos abaixo.</p>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								<label>Quantidade por venda (grama, kilo, unidade, caixa)</label>
								<input type="text" name="calc" value="1" id="calc" class="form-control unity"/>
							</div>
						</div>

						

						<div class="col-md-6">
							<div class="form-group">
								<label>Produto correspondente no aplicativo de venda</label>
			              		{!! Form::select('square_id', $squareItemsForSelect, null, ['class' => 'form-control', 'single' => 'single', 'id' => 'square', 'placeholder' => 'Selecione um produto'])   !!}
			              		<input type="hidden" value="" name="square_name" />
			        		</div>
						</div>
					</div>