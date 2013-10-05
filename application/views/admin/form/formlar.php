
	                                <fieldset>
						<legend>Formlar</legend>		
							
						<table class="table table-hover">
						      <thead>
							<tr>
							  <th>Id</th>
							  <th>Başlık</th>
							  <th>İncele</th>
							  <th>Sil</th>
							  <th>Dolduran Üyeler</th>
							  <th>İndir</th>
							</tr>
						      </thead>
						      <tbody>
							<?php foreach($formlar as $form){ ?>
						       <tr>
							   <td><?php echo $form['id']; ?></td>
							  <td><?php echo substr($form['baslik'],0,50); ?> ...</td>
					   
								<?php
									echo "<td><a href='{base_url}index.php/admin/form_incele?form_id=".$form['id']."' class='btn btn-small btn-primary'>Formu Incele</a></td>";
									echo "<td><a href='{base_url}index.php/admin/form_sil?form_id=".$form['id']."' class='btn btn-small btn-primary'>Formu Sil</a></td>";
									echo "<td><a href='{base_url}index.php/admin/formu_dolduran_uyeler?form_id=".$form['id']."' class='btn btn-small btn-primary'>Dolduran Uyeler</a></td>";
									echo "<td><a href='{base_url}index.php/admin/form_to_excel?form_id=".$form['id']."' class='btn btn-small btn-primary'>İndir</a></td>";
							 ?>
							</tr>
					    		<?php } ?>
						      </tbody>
						    </table>
						</fieldset>
