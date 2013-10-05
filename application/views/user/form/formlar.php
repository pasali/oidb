	<div class="span9">
	<table class="table table-hover">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Başlık</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
		<?php foreach($formlar as $form){ ?>
                <?php if($form['durum']=='dolduruldu'){
				echo "<tr class='success'>";}
			else{
				echo "<tr class='info'>";
			}
		 ?>
                  <td><?php echo $form['id']; ?></td>
                  <td><?php echo substr($form['baslik'],0,50); ?> ...</td>
   
			<?php if($form['durum']=='dolduruldu'){
				echo "<td><a href='{base_url}index.php/pages/form_incele?form_id=".$form['id']."' class='btn btn-small'>Formu İncele</a></td>";
			}
			else{
				echo "<td><a href='{base_url}index.php/pages/form_doldur?form_id=".$form['id']."' class='btn btn-small  btn-primary'>Formu Doldur</a></td>";
			}
		 ?>
		</tr>
    		<?php } ?>
              </tbody>
            </table>
	</div>
