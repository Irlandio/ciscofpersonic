
<style>
.badgebox
{opacity: 0;}
.badgebox + .badge
{ text-indent: -999999px;width: 27px;}
.badgebox:focus + .badge
{ box-shadow: inset 0px 0px 5px;}
.badgebox:checked + .badge
{text-indent: 0;}
</style>

   <div class="row-fluid" style="margin-top: 0">
    <div class="span4">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-list-alt"></i>
                </span>
                <h5>Relatórios Rápidos (Todas Contas)</h5>
            </div>
            <div class="widget-content">
                <ul class="site-stats">
                    <li><a target="_blank" href="<?php echo base_url()?>index.php/relatorios/vendasRapiddia" ><i class="icon-tags"></i> <small>Relatório do dia</small></a></li>
                    <li><a target="_blank" href="<?php echo base_url()?>index.php/relatorios/vendasRapidsemana" ><i class="icon-tags"></i> <small>Relatório da semana </small></a></li>
                    <li><a target="_blank" href="<?php echo base_url()?>index.php/relatorios/vendasRapidmes" ><i class="icon-tags"></i> <small>Relatório do mês</small></a></li>
                    <li><a target="_blank" href="<?php echo base_url()?>index.php/relatorios/vendasRapidano" ><i class="icon-tags"></i> <small>Relatório do ano</small></a></li>
                    
                </ul>
            </div>
        </div><?php //echo date('Y-m-d', strtotime('sunday last week', strtotime(date('Y-m-d'))))?>
    </div>

    <div class="span8">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-list-alt"></i>
                </span>
                <h5>Relatórios Customizáveis</h5>
            </div>
            <div class="widget-content">
                <div class="span12 well">

                    <form target="_blank" action="<?php echo base_url() ?>index.php/relatorios/vendasCustom" method="get">
                        <div class="span12 well">
                            <div class="span6">
                                <label for="">Data de:</label>
                                <input type="date" name="dataInicial" class="span12" />
                            </div>
                            <div class="span6">
                                <label for="">até:</label>
                                <input type="date"  name="dataFinal" class="span12" />
                            </div>
                        </div>
                        <div class="span12 well" style="margin-left: 0">
                            
                            
                            <div class="span3">
                                <label for="">Centros de custo:</label>
                                
                                <select  style="width:170px;" id="centros" name="centros">
                                <option value = ""></option>
                                <option value = "T00-000">"T00-000 | **VALORES NÃO CONTABILIZADOS (transferências entre contas contábeis da AENPAZ)"</option>
                                <option value = "T01-000">"T01-000 | **VALORES NÃO CONTABILIZADOS (transferências entre banco e peq. caixa ou investimento em aplicações)"</option>
                                <option value = "T02-000">"T02-000 | **VALORES NÃO CONTABILIZADOS (DOC's e TED's devolvidos ou estornos)"</option>
                                <option value = "D00-000">"D00-000 | **CHEQUES DEVOLVIDOS (sem fundos | debitados da conta bancária) **exclusivo IEADALPE**"</option>
                                <option value = "D01-010">"D01-010 | GASTOS COM PESSOAL"</option>
                                <option value = "D01-020">"D01-020 | ENCARGOS SOCIAIS **exclusivo Compassion**"</option>
                                <option value = "D01-021">"D01-021 | INSS"</option>
                                <option value = "D01-022">"D01-022 | FGTS"</option>
                                <option value = "D01-023">"D01-023 | PIS"</option>
                                <option value = "D01-024">"D01-024 | SINDICATOS"</option>
                                <option value = "D01-025">"D01-025 | IRRF SOBRE FOLHA"</option>
                                <option value = "D01-030">"D01-030 | SERVIÇOS DE TERCEIROS"</option>
                                <option value = "D01-040">"D01-040 | TREINAMENTOS"</option>
                                <option value = "D01-050">"D01-050 | MATERIAL DIDÁTICO E PEDAGÓGICO"</option>
                                <option value = "D01-060">"D01-060 | UNIFORMES PARA AS CRIANÇAS"</option>
                                <option value = "D01-070">"D01-070 | ATIVIDADES E CURSOS PROFISSIONALIZANTES"</option>
                                <option value = "D01-100">"D01-100 | OUTRAS DESPESAS"</option>
                                <option value = "D02-050">"D02-050 | MATERIAL DE SAÚDE (material para procedimentos e afins)"</option>
                                <option value = "D02-060">"D02-060 | AVALIAÇÕES E MONITORAMENTO DE SAÚDE"</option>
                                <option value = "D02-080">"D02-080 | ALIMENTAÇÃO GERAL (c/ beneficiários)"</option>
                                <option value = "D02-090">"D02-090 | MATERIAL PARA COZINHA (utensílios etc.)"</option>
                                <option value = "D02-110">"D02-110 | GÁS DE COZINHA"</option>
                                <option value = "D03-050">"D03-050 | MATERIAL DE EDUCAÇÃO CRISTÃ"</option>
                                <option value = "D04-050">"D04-050 | MATERIAL ESPORTIVO"</option>
                                <option value = "D04-060">"D04-060 | ATIVIDADES SÓCIO-ESPORTIVAS"</option>
                                <option value = "D04-100">"D04-100 | FESTIVIDADES COM AS CRIANÇAS"</option>
                                <option value = "D05-050">"D05-050 | MATERIAL PARA ESCRITÓRIO"</option>
                                <option value = "D05-060">"D05-060 | MATERIAL DE LIMPEZA"</option>
                                <option value = "D05-070">"D05-070 | DESPESAS ADM. (hospedagem, fardamentos, seg. eletrônica, cópias de chaves, aluguéis, encadernações, "</option>
                                <option value = "D05-080">"D05-080 | DESPESAS BANCÁRIAS"</option>
                                <option value = "D05-090">"D05-090 | MÓVEIS, EQUIPAMENTOS E UTENSÍLIOS "</option>
                                <option value = "D05-100">"D05-100 | MANUTENÇÃO PREDIAL"</option>
                                <option value = "D05-110">"D05-110 | SERVIÇOS DE CORREIOS"</option>
                                <option value = "D05-120">"D05-120 | MANUTENÇÃO DE EQUIPAMENTOS"</option>
                                <option value = "D05-130">"D05-130 | TELEFONE E INTERNET"</option>
                                <option value = "D05-140">"D05-140 | ENERGIA ELÉTRICA"</option>
                                <option value = "D05-150">"D05-150 | ÁGUA MINERAL"</option>
                                <option value = "D05-160">"D05-160 | OUTROS IMPOSTOS, TAXAS E CONTRIBUIÇÕES (inclusive custos cartoriais)"</option>
                                <option value = "D05-190">"D05-190 | TRANSPORTES COM PESSOAL (Ticket Car, VEM Trabalhador ou em espécie)"</option>
                                <option value = "D05-230">"D05-230 | ALIMENTAÇÃO COM PESSOAL"</option>
                                <option value = "D05-260">"D05-260 | DESCARTÁVEIS"</option>
                                <option value = "D06-010">"D06-010 | PRESENTES ESPECIAIS (Compassion)"</option>
                                <option value = "D06-020">"D06-020 | AJUDAS ESPECIAIS (saúde, desastre, outras ajudas etc.)"</option>
                                <option value = "D06-060">"D06-060 | FUNDOS COMPLEMENTARES CIV's (Compassion)"</option>
                                <option value = "D07-010">"D07-010 | IMPOSTO DE RENDA SOBRE RENDIMENTOS DE APLICAÇÃO"</option>
                                <option value = "D07-020">"D07-020 | MARKETING E CAPTAÇÃO DE RECURSOS"</option>
                                <option value = "D07-030">"D07-030 | AVALIAÇÃO DE DESEMPENHO"</option>
                                <option value = "D07-040">"D07-040 | COMBUSTÍVEIS"</option>
                                <option value = "D07-050">"D07-050 | BENEFÍCIOS COM PESSOAL"</option>
                                <option value = "D07-060">"D07-060 | MEDICAMENTOS"</option>
                                <option value = "D07-070">"D07-070 | DESPESAS COM VEÍCULOS (manutenção e afins)"</option>
                                <option value = "D07-080">"D07-080 | DESPESAS COM VEÍCULOS (seguros, taxas e afins)"</option>
                                <option value = "D07-090">"D07-090 | DESPESAS COM ESTACIONAMENTO E AFINS"</option>
                                <option value = "D07-100">"D07-100 | ÁGUA (Compesa)"</option>
                                <option value = "D07-110">"D07-110 | HIGIENE PESSOAL COM IDOSOS (fraldas geriátricas etc.)"</option>
                                <option value = "D07-120">"D07-120 | DESPESAS DIRETAS COM OS IDOSOS (repasse de 30%)"</option>
                                <option value = "T00">"T00 | **VALORES NÃO CONTABILIZADOS (transferências entre contas contábeis da AENPAZ)"</option>
                                <option value = "T01">"T01 | **VALORES NÃO CONTABILIZADOS (transferências entre banco e peq. caixa ou resgate de aplicações)"</option>
                                <option value = "T02">"T02 | **VALORES NÃO CONTABILIZADOS (DOC's e TED's devolvidos ou estornos)"</option>
                                <option value = "R00">"R00 | CHEQUES DEVOLVIDOS (reapresentados/compensados ou resgatados com o emissor)"</option>
                                <option value = "R01">"R01 | DOAÇÕES DA COMPASSION"</option>
                                <option value = "R02">"R02 | DOAÇÕES DA IEADALPE"</option>
                                <option value = "R03">"R03 | CENTRAL DE DOAÇÕES"</option>
                                <option value = "R04">"R04 | PROGRAMA DE APADRINHAMENTO"</option>
                                <option value = "R05">"R05 | DOAÇÕES DE PESSOA FÍSICA"</option>
                                <option value = "R06">"R06 | TODOS COM A NOTA"</option>
                                <option value = "R07">"R07 | ACERTO DE GASTOS NÃO AUTORIZADOS"</option>
                                <option value = "R08">"R08 | RENDIMENTOS DE APLICAÇÃO"</option>
                                <option value = "R09">"R09 | OUTRAS DOAÇÕES"</option>   
                                </select>

                            </div>
                            <div class="span3">           
                                
                                <label for="">Conta:</label>

                                        <select  style="width:170px;" id="conta_A" name="conta_A">
                                        <option value = ""></option>
                                        <option value = "1">"IEADALPE - 1444-3"</option>
                                        <option value = "2">"22360-3"</option>
                                        <option value = "3">"ILPI"</option>
                                        <option value = "4">"BR214"</option>
                                        <option value = "5">"BR518"</option>
                                        <option value = "6">"BR542"</option>
                                        <option value = "7">"BR549"</option>
                                        <option value = "8">"BR579"</option>
                                        <option value = "9">"BB 28965-5"</option>
                                        <option value = "10">"CEF 1948-4"</option>     
                                        </select>

                                </div>    
                            <div class="span3">
                                
                         <div class="span12" style="margin-left: 0; text-align: center">
                            <!--<input type="reset" class="btn" value="Limpar" />-->
                            <label  class="btn btn-default" submit><input  name="pdf"  type="checkbox" value="1"   class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> PDF</label>
                        </div>
                                <input type="hidden"  id="cliente" class="span12" />
                                <input type="hidden" name="cliente" id="clienteHide" />

                            </div>
                        </div>
          

                        <div class="span12" style="margin-left: 0; text-align: center">
                            <input type="reset" class="btn" value="Limpar" />
                            <button class="btn btn-inverse"><i class="icon-print icon-white"></i> Gerar</button>
                        </div>
                    </form>
                </div>
                .
            </div>
        </div>
    </div>
    
    
    <div class="span8">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-list-alt"></i>
                </span>
                <h5>Verificação de Lançamentos combinados</h5>
            </div>
            <div class="widget-content">
                <div class="span12 well">

                    <form target="_blank" action="<?php echo base_url() ?>index.php/relatorios/vendasCustom" method="get">
                        <div class="span12 well">
                            <div class="span6">
                                <label for="">Data de:</label>
                                <input type="date" name="dataInicial" class="span12" />
                            </div>
                            <div class="span6">
                                <label for="">até:</label>
                                <input type="date"  name="dataFinal" class="span12" />
                            </div>
                        </div>
                        <div class="span12 well" style="margin-left: 0">                            
                            
                            <div class="span3">
                                <label for="">Centros de custo:</label>
                                
                                <select  style="width:170px;" id="centros" name="centros">
                                <option value = "">"TODOS"</option>
                                <option value = "T-Contas">"T00-000 e T00  | **VALORES NÃO CONTABILIZADOS (transferências entre contas contábeis da AENPAZ)"</option>
                                <option value = "T-Suporte">"T01-000 e T01 | **VALORES NÃO CONTABILIZADOS (transferências entre banco e peq. caixa ou investimento em aplicações)"</option>
                                </select>

                            </div>
                            <div class="span3">
                                
                                <label for="">Situação:</label>

                                        <select  style="width:170px;" id="tipo" name="tipo">
                                        <option value = "1">"TODOS"</option>
                                        <option value = "2">"Com Pares"</option>
                                        <option value = "3">"Sem Pares"</option>
                                        <option value = "4">"Pendentes Com Pares"</option>
                                        <option value = "5">"Pendentes"</option>
                                        </select>

                                </div>  
                                
                            <input type="hilden" id="conta_A" name="conta_A" value="" /> 
                        </div>
           
                                
                         <div class="span2" style="margin-left: 0; text-align: center">
                            <!--<input type="reset" class="btn" value="Limpar" />-->
                            <label  class="btn btn-default" submit><input  name="excel"  type="checkbox" value="Corrente"   class="badgebox" style="margin-top:5px;"/><span class="badge" >&check;</span> Excel</label>
                        </div>

                        <div class="span12" style="margin-left: 0; text-align: center">
                            <input type="reset" class="btn" value="Limpar" />
                            <button class="btn btn-inverse"><i class="icon-print icon-white"></i> Gerar</button>
                        </div>
                    </form>
                </div>
                .
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script src="<?php echo base_url();?>assets/js/maskmoney.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".money").maskMoney();
        
        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteCliente",
            minLength: 2,
            select: function( event, ui ) {

                 $("#clienteHide").val(ui.item.id);


            }
      });

      $("#tecnico").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteUsuario",
            minLength: 2,
            select: function( event, ui ) {

                 $("#responsavelHide").val(ui.item.id);


            }
      });

    });
</script>