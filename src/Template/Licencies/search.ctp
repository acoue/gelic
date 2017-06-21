
<table cellpadding="0" cellspacing="0" class="table table-striped">
    <thead>
        <tr align='center'>
            <th width='20%'><?= $this->Paginator->sort('Nom') ?></th>
            <th width='40%'><?= $this->Paginator->sort('Prénom') ?></th>
            <th width='25%'><?= $this->Paginator->sort('Club') ?></th>
            <th  width='15%' class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($licencies as $licencie): ?>
        <tr>
            <td><?= h($licencie->prenom) ?></td>
            <td><?= h($licencie->nom) ?></td>
            <td><?= h($licencie->club->name) ?></td>
            <td class="actions">
            <?= $this->Html->link(__('Editer'), ['action' => 'edit', $licencie->id])?>
            &nbsp;&nbsp;
            <?= $this->Html->link(__('Palmares'),['controller'=>'Palmares','action' => 'palmares', $licencie->id]) ?>
          	</td>
        </tr>

    <?php endforeach; ?>
    </tbody>
</table>