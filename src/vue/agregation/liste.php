<div class="marge">
    <table>
        <thead>
        <th>Id Agregation</th>
        <th>Nom Agregation</th>
        <th>Note</th>
        <th>Id Etudiant</th>
        </thead>


        <tbody>
        <?php
        /**
         * @var \App\Sae\Modele\DataObject\Agregation[] $agregations
         */
        foreach ($agregations as $agregation) {
            echo '
   <tr>
    <td>'.$agregation->getIdAgregation().' </td>
    <td>'.$agregation->getNomAgregation().'</td>
    <td>'.$agregation->getNoteAgregation().'</td> 
    <td>'.$agregation->getEtudiant()->getEtudid().' </td>
    </tr>
     
    ';
        }
        ?>
        </tbody>
    </table>

</div>
