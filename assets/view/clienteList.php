<?php
    $clienteList = new model\ClienteModel();
    $clientes = $clienteList->list();
?>

<div class="container table-responsive">
    <div class="mt-2">
        <h2>Listagem</h2>
    </div>
    <table class="mt-3 table table-striped table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th scope="col">Codigo	</th>
                <th scope="col">Nome	</th>
                <th scope="col">Email	</th>
                <th scope="col">CPF	  	</th>
                <th scope="col">Celular	</th>
                <th scope="col" class="text-center"> Ações </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($clientes as $cli) { ?>
            <tr>
                <td scope="row"> <?=$cli["id"]; ?> 		 </th>
                <td> <?=$cli["nome"];    ?>				 </td>
                <td> <?=($cli["email"]); ?>              </td>
                <td> <?=formatCnpjCpf($cli["cpf"]); ?>	 </td>
                <td> <?=formatPhone($cli["celular"]); ?> </td>
                <td class="text-center">
                    <a class="btn btn-info btn-sm" href="index.php?page=clienteForm&id=<?=$cli['id']; ?>&action=view" role="button">
                        Visualizar
                    </a>
                    <a class="btn btn-warning btn-sm" href="index.php?page=clienteForm&id=<?=$cli['id']; ?>&action=edit" role="button">
                        Editar
                    </a>
                    <button class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#modal<?=$cli['id'];?>">
                        Remover
                    </button>
                </td>
                <?php viewRemove($cli["id"], $cli["nome"]); ?>      
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="index.php?page=clienteForm" class="btn btn-primary" role="button" aria-pressed="true">Adicionar</a>
</div>