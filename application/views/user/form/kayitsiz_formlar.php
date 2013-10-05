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
               <tr class='info'>
                  <td><?php echo $form['id']; ?></td>
                  <td><?php echo substr($form['baslik'],0,50); ?> ...</td>
   
			<td><a href='{base_url}index.php/pages/kayitsiz_form_doldur/<?php echo $form['id']; ?>' class='btn btn-small  btn-primary'>Formu Doldur</a></td>
		</tr>
    		<?php } ?>
              </tbody>
            </table>
	</div>
