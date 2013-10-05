		    <div class="row-fluid">
                        <div class="span6">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Son Kaydolan Kullanıcılar</div>
                                    </div>
                                <div class="block-content collapse in">
                                     <table class="table table-striped">
					      <thead>
						<tr>
						  <th>İsim-Soyisim</th>
						  <th>E-posta</th>
						  <th>Zaman</th>
						</tr>
					      </thead>
					      <tbody>
						{son_kullanicilar}
						<tr>
						  <td>{isim} {soyisim}</td>
						  <td>{email}</td>
						  <td>{zaman}</td>
						</tr>
						{/son_kullanicilar}
					      </tbody>
					    </table>

                                </div>
                            </div>
                            <!-- /block -->
                        </div>
                        <div class="span6">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Son Formlar</div>

                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Başlık</th>
                                                <th>Zaman</th>
                                            </tr>
                                        </thead>
                                        <tbody>
					<?php foreach($son_formlar as $form){
                                           echo "<tr>
                                                	<td>".substr($form['baslik'],0,30)." ...</td>
                                                	<td>".$form['zaman']."</td>
                                            	</tr>";
						}?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /block -->
                        </div>
			<div class="span11">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Son Doldurulan Formlar</div>
                                    </div>
                                <div class="block-content collapse in">
                                     <table class="table table-striped">
					      <thead>
						<tr>
						  <th>Kullanıcı</th>
						  <th>Başlık</th>
						  <th>Zaman</th>
						</tr>
					      </thead>
					      <tbody>
					<?php foreach($son_doldurulan_formlar as $form){
                                           echo "<tr>
						  <td>".$form['kullanici']."</td>
						  <td>".substr($form['form_baslik'],0,60)."...</td>
						  <td>".$form['zaman']."</td>				 
						</tr>";
						} ?>
					      </tbody>
					    </table>


                                </div>
                            </div>
                            <!-- /block -->
                        </div>
                    </div>
                </div>
 
