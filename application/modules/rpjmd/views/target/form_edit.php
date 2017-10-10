<div class="row">
	<div class="col-md-12">
		<div id="message"></div>
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<h3 class="box-title"><?= isset($head) ? $head : ''; ?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<form id="formID" role="form" action="" method="post">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
			<input type="hidden" name="indikator_id" value="<?= $record->id; ?>" />
			<!-- box-body -->
			<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						<div class="alert bg-light-blue color-palette alert-dismissible">
						<dl class="dl-horizontal">
							<dt>PERIODE</dt>
							<dd><?= $record->periode; ?></dd>
							<dt>VISI</dt>
							<dd><?= $record->visi; ?></dd>
							<dt>MISI</dt>
							<dd><?= $record->misi; ?></dd>
							<dt>TUJUAN</dt>
							<dd><?= $record->tujuan; ?></dd>
							<dt>SASARAN</dt>
							<dd><?= $record->sasaran; ?></dd>
							<dt>INDIKATOR</dt>
							<dd><?= $record->indikator; ?></dd>
						</dl>
						</div>
					</div>
					<?php $periode = $this->db->get_where('ref_periode', array('id'=>$record->periode_id))->row_array(); ?>
					<?php if($periode){ ?>
					<?php for($i = $periode['awal']-1; $i <= $periode['akhir']; $i++){ ?>
						<?php if($i == $periode['awal']-1){ ?>
							<div class="col-md-6">
							<div class="form-group <?php echo form_error('target') ? 'has-error' : null; ?>">
							<?php
							echo form_label('Kondisi '.$i,'target');
							$data = array('class'=>'form-control','name'=>'target[]','id'=>'target','type'=>'text','value'=>set_value('target[]'));
							echo form_input($data);
							echo form_error('target') ? form_error('target', '<p class="help-block">','</p>') : '';
							?>
							<input type="hidden" name="tahun[]" value="<?= $i; ?>" />
							</div>
							</div>
						<?php }elseif($i == $periode['akhir']){ ?>
							<div class="col-md-6">
							<div class="form-group <?php echo form_error('target') ? 'has-error' : null; ?>">
							<?php
							echo form_label('Target Akhir '.$i,'target');
							$data = array('class'=>'form-control','name'=>'target[]','id'=>'target','type'=>'text','value'=>set_value('target[]'));
							echo form_input($data);
							echo form_error('target') ? form_error('target', '<p class="help-block">','</p>') : '';
							?>
							<input type="hidden" name="tahun[]" value="<?= $i; ?>" />
							</div>
							</div>	
						<?php }else{ ?>
							<div class="col-md-6">
							<div class="form-group <?php echo form_error('target') ? 'has-error' : null; ?>">
							<?php
							echo form_label('Target '.$i,'target');
							$data = array('class'=>'form-control','name'=>'target[]','id'=>'target','type'=>'text','value'=>set_value('target[]'));
							echo form_input($data);
							echo form_error('target') ? form_error('target', '<p class="help-block">','</p>') : '';
							?>
							<input type="hidden" name="tahun[]" value="<?= $i; ?>" />
							</div>
							</div>
						<?php } ?>
					<?php } ?>
					<?php } ?>
				</div>
			</div>
			<!-- ./box-body -->
			<div class="box-footer">
				<button type="button" class="btn btn-sm btn-flat btn-success" onclick="save()"><i class="fa fa-save"></i> Simpan</button>
				<button type="button" class="btn btn-sm btn-flat btn-info" onclick="saveout();"><i class="fa fa-save"></i> Simpan & Keluar</button>
				<button type="reset" class="btn btn-sm btn-flat btn-warning"><i class="fa fa-refresh"></i> Reset</button>
				<button type="button" class="btn btn-sm btn-flat btn-danger" onclick="back();"><i class="fa fa-close"></i> Keluar</button>
			</div>
			</form>
		</div>
	</div>
</div>