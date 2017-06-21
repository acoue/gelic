<div class="blocblanc">
	<h2>Administration</h2>
    <h3>Club</h3>
	<div class="blocblancContent">
		<div class="row">
			<div class="col-lg-2"></div>
			<div class="col-lg-20"> 
				<table cellpadding="0" cellspacing="0" class="table table-striped">
				    <thead>
				        <tr>
			                <th><?= $this->Paginator->sort('id') ?></th>
			                <th><?= $this->Paginator->sort('name') ?></th>
			                <th><?= $this->Paginator->sort('region_id') ?></th>
			                <th class="actions"><?= __('Actions') ?></th>
				        </tr>
				    </thead>
				    <tbody> 
				    <?php foreach ($clubs as $club): ?>
			            <tr>
                			<td><?= $this->Number->format($club->id) ?></td>
                			<td><?= h($club->name) ?></td>
			                <th><?= h($club->region->name) ?></th>
			                <td class="actions">
			                    <?= $this->Html->link(__('Voir'), ['action' => 'view', $club->id]) ?>
			                    <?= $this->Html->link(__('Editer'), ['action' => 'edit', $club->id]) ?>
			                    <?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $club->id], ['confirm' => __('Etes-vous sûr de vouloir supprimer le club {0} ?', $club->name)]) ?>
			                </td>
			            </tr>
			        <?php endforeach; ?>
				    </tbody>
				   </table>
				   <br />
					<p align="center">
						<?= $this->Html->link(__('Créer un club'), ['action' => 'add'], ['class'=>'btn btn-default']) ?><br /><br />
						<?= $this->Html->link(__('Retour'), ['controller'=>'admin', 'action' => 'index'],['class' => 'btn btn-info']) ?> 
					</p>
					<div class="paginator">
				        <ul class="pagination">
				            <?= $this->Paginator->prev('< ' . __('Préc.')) ?>
				            <?= $this->Paginator->numbers() ?>
				            <?= $this->Paginator->next(__('Suiv.') . ' >') ?>
				        </ul>
				        <p><?= $this->Paginator->counter() ?></p>
				    </div><br />
				</div>						
			<div class="col-lg-2"></div>
		</div>
	</div>
</div>