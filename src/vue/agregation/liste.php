<div class="marge">
    <table>
        <thead>
        <th>Id Agregation</th>
        <th>Nom Agregation</th>
        </thead>


        <tbody>
        <?php
        /**
         * @var \App\Sae\Modele\DataObject\Agregation[] $agregations
         */
        foreach ($agregations as $agregation) {
            echo '
   <tr>
    <td> <a href="?controleur=agregation&action=afficherDetail&id=' . rawurlencode($agregation->getIdAgregation()) . '">' . $agregation->getIdAgregation() . '</a></td>
    <td><a href="?controleur=agregation&action=afficherDetail&id=' . rawurlencode($agregation->getIdAgregation()) . '">' . htmlspecialchars($agregation->getNomAgregation()) . '</td> 
    </tr>';
        }
        ?>
        </tbody>
    </table>

</div>
