<div class="blocblanc">
	<h2>Administration</h2>
    <h3>Licencié - Ajout</h3>
	<div class="blocblancContent large-9 medium-8 columns content">
		<div class="row">
			<div class="col-lg-2"></div>
			<div class="col-lg-5">
				<?= $this->Html->link(__('Retour'), ['action' => 'index'],['class' => 'btn btn-info']) ?> 
			</div>
			<div class="col-lg-15"> 
			    <?= $this->Form->create($licency, ['id'=>'formulaire']) ?>
			    <div class="row">
                	<label class="col-lg-8 control-label" for="nom">Nom <span class="obligatoire"><sup> *</sup></span></label>
                    <div class="col-lg-16"><?= $this->Form->input('nom', ['label' => false,'id'=>'nom',
														   	'div' => false,
															'class' => 'form-control', 
                    										'type' => 'text', 
															'required' =>'required']); ?>
                    </div>                          
				</div><br /> 
			    <div class="row">
                	<label class="col-lg-8 control-label" for="prenom">Prénom <span class="obligatoire"><sup> *</sup></span></label>
                    <div class="col-lg-16"><?= $this->Form->input('prenom', ['label' => false,'id'=>'prenom',
														   	'div' => false,
															'class' => 'form-control', 
                    										'type' => 'text', 
															'required' =>'required']); ?>
                    </div>                          
				</div><br /> 
				<div class="row">
                	<label class="col-md-8 control-label" for="sexe">Sexe <span class="obligatoire"> *</span></label>
                    <div class="col-md-14"><?= $this->Form->input('sexe', ['label' => false,'id'=>'sexe',
														   	'div' => false,	'class' => 'form-control',
                    		'required' =>'required', 
                    										'options'=>[''=>'Sélectionner','F'=>'Femme','H'=>'Homme']]); ?>
                    </div>                          
				</div><br /> 
				<div class="row">
                	<label class="col-lg-8 control-label" for="club_id">Club <span class="obligatoire"> *</span></label>
                	<div class="col-lg-16"><?= $this->Form->input('club_id', ['label' => false,
                											'options' => $clubs,
                											'div' => false,
															'class' => 'form-control', 
                    										'required' =>'required']) ?>    
                	</div>                 
				</div><br />  
				<div class="row">
                	<label class="col-lg-8 control-label" for="discipline_id">Discipline <span class="obligatoire"> *</span></label>
                	<div class="col-lg-16"><?= $this->Form->input('discipline_id', ['label' => false,
                											'options' => $disciplines,
                											'div' => false,
															'class' => 'form-control', 
                    										'required' =>'required']) ?>    
                	</div>                 
				</div><br /> 
				<div class="row">
                	<label class="col-md-8 control-label" for="ddn">Date de naissance</label>
                    <div class="col-md-14"><?= $this->Form->input('ddn', ['label' => false,'id'=>'ddn',
														   	'div' => false,'value'=>'',
															'class' => 'form-control', 
                    										'type' => 'text']); ?>
                    </div>                          
				</div><br />
				<div class="row">
                	<label class="col-md-8 control-label" for="licence">Numéro de licence </label>
                    <div class="col-md-14"><?= $this->Form->input('licence', ['label' => false,'id'=>'licence',
														   	'div' => false,
															'class' => 'form-control']); ?>
                    </div>                          
				</div><br />
				<div class="row">
                	<label class="col-md-8 control-label" for="grade_id">Grade</label>
                    <div class="col-md-14"><?= $this->Form->input('grade_id', ['label' => false,'id'=>'grade_id',
														   	'div' => false,
															'class' => 'form-control', 
                    										'options' => $grades]); ?>
                    </div>                          
				</div><br />
			    <?= $this->Form->button(__('Valider'),['class'=>'btn btn-default']) ?>
			    <?= $this->Form->end() ?>
				<p align='left'><span class="obligatoire">&nbsp;&nbsp;&nbsp;&nbsp;<sup>*</sup></span> Champ obligatoire</p>	
			</div>						
			<div class="col-lg-2"></div>
		</div>
	</div>
</div>