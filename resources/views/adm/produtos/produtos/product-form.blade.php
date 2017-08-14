<div class="row">

						<div class="col-md-6">
							<div class="form-group">
								<label>Nome</label>
								<input type="text" name="nome_produto" value="{{ (isset($produto))  ? $produto->nome_produto : ''}}" class="form-control">
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
								<input type="text" name="descricao" value="{{ (isset($produto)) ? $produto->descricao : ''}}" class="form-control">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Preço médio</label>
								<input type="text" name="preco" value="{{ ( isset($produto)) ? $produto->preco : ''}}" class="form-control money"/>
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
