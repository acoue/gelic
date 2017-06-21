<div class="blocGris">
	<h2>Administration</h2>
	<div class="container">
		<div class="table-responsive">
	    	<table class="table" width="60%">
			    <tbody>	
			        <tr>
			            <td width='70%'>Voir le journal</td>
			            <td width='30%'><?= $this->Html->link('Historique', ['controller'=>'Historiques', 'action' => 'index'],['class' => 'btn btn-default']) ?></td>
			        </tr>
			        <tr>
			            <td >Administration des Utilisateurs</td>
			            <td ><?= $this->Html->link('Utilisateurs', ['controller'=>'users', 'action' => 'index'],['class' => 'btn btn-default']) ?></td>
			        </tr>
			        <tr>
			            <td>Administration des Régions</td>
			            <td><?= $this->Html->link('Régions', ['controller'=>'Regions', 'action' => 'index'],['class' => 'btn btn-default']) ?></td>
			        </tr>	
			        <tr>
			            <td>Administration des Clubs</td>
			            <td><?= $this->Html->link('Club', ['controller'=>'Clubs', 'action' => 'index'],['class' => 'btn btn-default']) ?></td>
			        </tr>	
			    </tbody>
		    </table>
		</div>
	</div>
</div>