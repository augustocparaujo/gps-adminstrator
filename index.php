<?php 
include_once ('topo.php');
echo'  
        <!-- content-wrapper start -->
          <div class="content-wrapper">
            <!--start página-->            
            <!-- Page Title Header Ends-->
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-3 col-md-6">
                        <div class="d-flex">
                          <div class="wrapper">
                            <h3 class="mb-0 font-weight-semibold">1</h3>
                            <h5 class="mb-0 font-weight-medium text-primary">Clientes</h5>
                            <p class="mb-0 text-muted">Veja mais</p>
                          </div>
                          <div class="wrapper my-auto ml-auto ml-lg-4">
                            <i class="fa fa-users fa-3x text-primary"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                        <div class="d-flex">
                          <div class="wrapper">
                            <h3 class="mb-0 font-weight-semibold">100</h3>
                            <h5 class="mb-0 font-weight-medium text-primary">Contratos</h5>
                            <p class="mb-0 text-muted">Veja mais</p>
                          </div>
                          <div class="wrapper my-auto ml-auto ml-lg-4">
                            <i class="fa fa-address-book-o fa-3x text-primary"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                        <div class="d-flex">
                          <div class="wrapper">
                            <h3 class="mb-0 font-weight-semibold"><small>R$</small> 7,688</h3>
                            <h5 class="mb-0 font-weight-medium text-primary">Títulos</h5>
                            <p class="mb-0 text-muted">Veja mais</p>
                          </div>
                          <div class="wrapper my-auto ml-auto ml-lg-4">
                            <canvas height="50" width="100" id="stats-line-graph-3"></canvas>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                        <div class="d-flex">
                          <div class="wrapper">
                            <h3 class="mb-0 font-weight-semibold"><small>R$</small> 1,553</h3>
                            <h5 class="mb-0 font-weight-medium text-primary">Caixa</h5>
                            <p class="mb-0 text-muted">Veja mais</p>
                          </div>
                          <div class="wrapper my-auto ml-auto ml-lg-4">
                            <canvas height="50" width="100" id="stats-line-graph-4"></canvas>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <!-- grafico -->
            <div class="row">
            <div class="col-md-12 grid-margin">
                    <div class="card">
                      <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <h4 class="card-title mb-0">Estatistica de venda ano</h4>
                        <div class="d-flex align-items-center justify-content-between w-100">
                          <div class="dropdown"></div>
                        </div>
                        <div class="d-flex align-items-end">
                          <h3 class="mb-0 font-weight-semibold">R$ 36.2531,00</h3>
                          <p class="mb-0 text-success font-weight-semibold mb-1">(+1.37%)</p>
                        </div>
                        <canvas class="mt-4 chartjs-render-monitor" height="200" id="market-overview-chart" width="1074" style="display: block; width: 537px; height: 179px;"></canvas>
                      </div>
                    </div>
                  </div>
                  </div>
                  <!-- grafico -->


                  <!-- ultimas vendas -->

                  <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">ùltimas vendas realizadas</h4>
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th> Cliente </th>
                            <th> Produto </th>
                            <th> Situação </th>
                            <th> Valor </th>
                            <th> Data </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="py-1">
                              <img src="assets/images/faces-clipart/pic-1.png" alt="image"> Cliente X</td>
                            
                              <td> Produto X </td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            <td> R$ 77.99 </td>
                            <td> May 15, 2015 </td>
                          </tr>
                          <tr>
                            <td class="py-1">
                              <img src="assets/images/faces-clipart/pic-2.png" alt="image"> Cliente X</td>
                            
                              <td> Produto X </td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            <td> R$245.30 </td>
                            <td> July 1, 2015 </td>
                          </tr>
                          <tr>
                            <td class="py-1">
                              <img src="assets/images/faces-clipart/pic-3.png" alt="image"> Cliente X</td>
                            
                              <td> Produto X </td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width:100%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            <td> R$138.00 </td>
                            <td> Apr 12, 2015 </td>
                          </tr>
                          <tr>
                            <td class="py-1">
                              <img src="assets/images/faces-clipart/pic-4.png" alt="image"> Cliente X</td>
                            
                              <td> Produto X </td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            <td> R$ 77.99 </td>
                            <td> May 15, 2015 </td>
                          </tr>
                          <tr>
                            <td class="py-1">
                              <img src="assets/images/faces-clipart/pic-1.png" alt="image"> Cliente X</td>
                            
                              <td> Produto X </td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            <td> R$ 160.25 </td>
                            <td> May 03, 2015 </td>
                          </tr>
                          <tr>
                            <td class="py-1">
                              <img src="assets/images/faces-clipart/pic-2.png" alt="image"> Cliente X</td>
                            
                              <td> Produto X </td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            <td> R$ 123.21 </td>
                            <td> April 05, 2015 </td>
                          </tr>
                          <tr>
                            <td class="py-1">
                              <img src="assets/images/faces-clipart/pic-3.png" alt="image"> Cliente X</td>
                            
                              <td> Produto X </td>
                            <td>
                              <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 100%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            <td> R$ 150.00 </td>
                            <td> June 16, 2015 </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                  <!-- ultimas vendas -->


            <!--end página-->
          </div>

          <!-- content-wrapper ends -->
';
include_once('rodape.php');
