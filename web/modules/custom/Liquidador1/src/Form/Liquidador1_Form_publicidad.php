<?php

namespace Drupal\Liquidador1\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\taxonomy\Entity\Term;
use Drupal\node\Entity\Node;
/**
 * Implements a codimth Simple Form API.
 */
class Liquidador1_Form_publicidad extends FormBase
{

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   * @return array
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['s0'] = [
      '#type' => 'markup',
      '#markup' => '<hr><p><div>Viabilidad para Publicidad Exterior Visual Fija</div></p>',
    ];

    $form['barrio'] = array(
      '#type' => 'entity_autocomplete',
      '#title' => t('Barrio'),
           '#description' => '<p>Seleccionar el barrio de Cartagena de Indias de  donde se realizará el evento.</p><p> El formulario sólo  tendrá validez en los Barrios que generan coincidencia al escribir.</p>',
      '#target_type' => 'taxonomy_term',
      '#selection_settings' => [
          'include_anonymous' => FALSE,
          'target_bundles' => array('Barrios'),
      ],
  );

  $form['direccion_evento'] = [
    '#type' => 'textfield',
    '#title' => 'Dirección del El Evento',
   // '#required' => TRUE,
    '#description' => 'Dirección donde se realizará El evento mencionado en la publicidad.',
  ];

    $form['s1'] = [
      '#type' => 'markup',
      '#markup' => '<hr>',
    ];

    $form['valor_evento'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Valor del Proyecto'),

      //'#required' => TRUE,
    ];

    $form['valor_letras'] = [
      '#type' => 'textfield',
      '#title' => 'Valor en letras',
      '#placeholder' => 'Ej: Cien mil doscientos pesos',
     // '#required' => TRUE,
    ];

    $form['descripcion_evento'] = [
      '#type' => 'textfield',
      '#title' => 'Breve Descripción del Evento',

     // '#required' => TRUE,
    ];


    $form['s2'] = [
      '#type' => 'markup',
      '#markup' => '<hr><p><div>Información de quien Realiza la liquidación</div></p>',
    ];


    $form['tipo_de_solicitante'] = [
      '#type' => 'radios',
     // '#required' => TRUE,
      '#title' => $this->t('Tipo de Solicitante'),
      '#default_value' => 'natural',
      '#options' => [

        'natural' => $this->t('Persona Natural'),
        'juridica' => $this->t('Persona Jurídica'),
      ],
      '#attributes' => [

        'name' => 'field_select',
      ],

      '#states' => [
        'enabled' => [

          ':input[name="field_custom"]' => ['value' => ''],
        ],
      ],
    ];
    $form['id_document'] = [
      '#type' => 'textfield',
     // '#required' => TRUE,
      '#placeholder' => 'Documento de Identidad / NIT',
    ];



    $form['name'] = [
      '#type' => 'textfield',
      '#size' => '60',
      '#required' => TRUE,
      '#placeholder' => 'Nombre / Reprecentante legal ',
      '#description' => 'Nombre de la persona natural o Representante legal.',
    ];




    $form['dir_correspondencia'] = [
      '#type' => 'textfield',
    //  '#required' => TRUE,
      '#placeholder' => 'Dirección de Correspondencia',
    ];
    $form['email'] = [
      '#type' => 'email',
      //'#required' => TRUE,
      '#placeholder' => 'Correo Electrónico',
    ];
    $form['tfijo'] = [
      '#type' => 'textfield',

      '#placeholder' => 'Teléfono fijo',
    ];

    $form['tmovil'] = [
      '#type' => 'textfield',
      //'#required' => TRUE,
      '#placeholder' => 'Teléfono móvil',
    ];

    $form['estrato'] = array(
      '#title' => t('Estrato'),
      '#type' => 'select',
      //'#required' => TRUE,
      '#description' => 'Seleccionar el estrato de quien realiza la liquidación.',
      '#options' => array(t('--- Seleccionar ---'), t('1'), t('2'), t('3'), t('4') , t('5') , t('6')    ),
    );

    $form['condicion'] = array(
      '#title' => t('¿Se encuentra en alguna condición especial?'),
      '#type' => 'select',
         '#options' => array(t('--- Seleccionar ---'), t('Adulto mayor'), t('Habitante de la calle'), t('Mujer gestante'), t('Peligro inminente') , t('Persona en condición de discapacidad') , t('Víctima del conflicto armado') , t('Menor de edad')     ),
    );

    $form['s3'] = [
      '#type' => 'markup',
      '#markup' => '<hr><p><div>Documentos Requeridos:</div>
    Cargar todos los documentos en un solo archivo PDF con un tamaño de archivo inferior a : 6MB.
      </p>',
    ];

    $form['documentos_natural'] = [
      '#type' => 'markup',
      '#markup' => '<hr><h2>Persona Jurídica:</h2>

      <ul>
        <li> Certificado de existencia y representación legal</li>
        <li>


      Certificado de existencia y representación legal </li>
       <li>Juntas de Acción Comunal: Certificado de existencia y representación legal.  </li>
        <li>Personería Jurídica y/o Certificación e
      Inscripción de Dignatarios (expedida por la Gobernación).</li>

      <li>Propietario del inmueble: Certificado de libertad y tradición (fecha de expedición no superior a 3 meses) </li>
      <li>Tenedor: Copia del documento que lo acredite como tal (contrato de arrendamiento, comodato, etc.) o autorización del
      propietario o poseedor.</li>
      Poseedor: Manifestación escrita y firmada de tal calidad.</li>
       <li>Copia de la escritura Pública del predio</li>
      <li>Poder debidamente otorgado, cuando actúe como apoderado.</li>
       <li>Documentos que acrediten la calidad del solicitante frente al Predio.</li>
      </ul>
      <hr>
      </br>

      <h2>Persona Natural:</h2>

<ul>
  <li>Documento de Identidad.</li>
  <li>
Certificado de existencia y representación legal </li>
 <li>Certificado de libertad y tradición (fecha de expedición no superior a 3 meses). </li>
  <li>Tenedor: Copia del documento que lo acredite como tal (contrato de arrendamiento, comodato, etc.) o autorización del
propietario o poseedor. </li>

<li>Poseedor: Manifestación escrita y firmada de tal calidad
Copia de la escritura Pública del predio.</li>

<li>Poder debidamente otorgado, cuando actúe como apoderado</li>

Poseedor: Manifestación escrita y firmada de tal calidad.</li>
 <li>Copia de la escritura Pública del predio</li>
<li>Poder debidamente otorgado, cuando actúe como apoderado.</li>
 <li>Documentos que acrediten la calidad del solicitante frente al Predio</li>
</ul>

      ',


    ];

    $form['archivo'] = [
      '#type' => 'file',
      '#title' => $this->t('Soportes'),
      '#description' => 'Límite: 6MB./ PDF',
         ];

    $form['list'] = [
      '#type' => 'markup',
      '#markup' => '<hr>',
    ];

    $form['accept'] = array(
      '#type' => 'checkbox',
      '#title' => $this
        ->t('Yo, Acepto terminos y condiciones del uso de mis datos personales.'),
      '#description' => $this->t('<a href="http://epacartagena.gov.co/web/wp-content/uploads/2021/01/PLAN-DE-TRAMIENTO-DE-RIESGOS-DE-SEGURIDAD-Y-PRIVACIDAD-DE-LA-INFORMACION_2021.pdf" target="_blank">Política de tratamiento de datos personales</a>'),
    );

// Data


    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Liquidar'),
    ];



    $form['list'] = [
      '#type' => 'markup',
      '#markup' => '<hr><br/>',
    ];

    return $form;
  }

  /**
   * @return string
   */
  public function getFormId()
  {
    return 'Liquidador1_Form';
  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {



  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {




    $vocabulary_name = 'tarifa_arboles';
    $query = \Drupal::entityQuery('taxonomy_term');
    $query->condition('vid', $vocabulary_name);
    $tids = $query->execute();
    $terms = Term::loadMultiple($tids);


    foreach ($terms as $term) {
      $id2 = $term->getFields();
          $value  = $term->get('field_tarifa_arboles')->getValue();

    }





/*

Valores  obtebidos para la firma

**/
/*

Valores  obtebidos para la Liquidación

**/
$valor =$value[0]["value"];
/*

Valores  obtebidos para la Informacion de la factura

**/
$valor_tarifa_evento_25 = $valor * 25 ;
$valor_tarifa_evento_35 = $valor * 35 ;
$valor_tarifa_evento_50 = $valor * 50 ;
$valor_tarifa_evento_70 = $valor * 70 ;
$valor_tarifa_evento_100 = $valor * 100 ;
$valor_tarifa_evento_200 = $valor * 200 ;
$valor_tarifa_evento_300 = $valor * 300 ;
$valor_tarifa_evento_400 = $valor * 400 ;
$valor_tarifa_evento_500 = $valor * 500 ;
$valor_tarifa_evento_700 = $valor * 700 ;
$valor_tarifa_evento_900 = $valor * 900 ;
$valor_tarifa_evento_1500 = $valor * 1500 ;
$valor_tarifa_evento_2115 = $valor * 2115 ;
$valor_tarifa_evento_8458 = $valor * 8458 ;

$codigo_liquidacion = $form_state->getValue('id_document');
$barrio_liquidacion = $form_state->getValue('barrio');
$direccion_predio_liquidacion = $form_state->getValue('dir_predio');
$tipo_solicitante = $form_state->getValue('tipo_de_solicitante');
$id_contribuyente = $form_state->getValue('id_document');
$name_contrib= $form_state->getValue('name');
$valor_evento = $form_state->getValue('valor_evento');
$valor_letras = $form_state->getValue('valor_letras');
$descripcion_evento = $form_state->getValue('descripcion_evento');
$direccion_evento = $form_state->getValue('direccion_evento');


if ($valor_liquidacion  <= $valor_tarifa_evento_25) {
  $valor_liquidacion = 114001;
} elseif ($valor_liquidacion  > $valor_tarifa_evento_25  && $valor_liquidacion <= $valor_tarifa_evento_35) {
  $valor_liquidacion = 159785;
}elseif ($valor_liquidacion  > $valor_tarifa_evento_35  && $valor_liquidacion <= $valor_tarifa_evento_50) {
  $valor_liquidacion = 228460;
}elseif ($valor_liquidacion  > $valor_tarifa_evento_70  && $valor_liquidacion <= $valor_tarifa_evento_100) {
  $valor_liquidacion = 320028;
}elseif ($valor_liquidacion  > $valor_tarifa_evento_100  && $valor_liquidacion <= $valor_tarifa_evento_200) {
  $valor_liquidacion = 457377;
}elseif ($valor_liquidacion  > $valor_tarifa_evento_200  && $valor_liquidacion <= $valor_tarifa_evento_300) {
  $valor_liquidacion = 915196;
}elseif ($valor_liquidacion  > $valor_tarifa_evento_300  && $valor_liquidacion <= $valor_tarifa_evento_400) {
  $valor_liquidacion = 1373049;
}elseif ($valor_liquidacion  > $valor_tarifa_evento_400  && $valor_liquidacion <= $valor_tarifa_evento_500) {
  $valor_liquidacion = 1830885;
}elseif ($valor_liquidacion  > $valor_tarifa_evento_500  && $valor_liquidacion <= $valor_tarifa_evento_700) {
  $valor_liquidacion = 2288721;
}elseif ($valor_liquidacion  > $valor_tarifa_evento_700  && $valor_liquidacion <= $valor_tarifa_evento_900) {
  $valor_liquidacion = 3204392;
}elseif ($valor_liquidacion  > $valor_tarifa_evento_900  && $valor_liquidacion <= $valor_tarifa_evento_1500) {
  $valor_liquidacion = 4120063;
}elseif ($valor_liquidacion  > $valor_tarifa_evento_1500  && $valor_liquidacion <= $valor_tarifa_evento_2115) {
  $valor_liquidacion = 9682767;
}elseif ($valor_liquidacion  > $valor_tarifa_evento_2115  && $valor_liquidacion <= $valor_tarifa_evento_8458) {
  $valor_liquidacion = 35937441;
}else {
  $valor_liquidacion = ($valor_evento * 10)/100;
}




$dir_correspondecia_contrib = $form_state->getValue('dir_correspondencia');
$email_cotrib = $form_state->getValue('email');
$tfijo = $form_state->getValue('tfijo');
$tmovil = $form_state->getValue('tmovil');
$estrato = $form_state->getValue('estrato');
$condicion = $form_state->getValue('condicion');
/*

Creando un nodo tipo factura con los datos recibidos

**/
$my_article = Node::create(['type' => 'factura']);
$my_article->set('title', $codigo_liquidacion);
$my_article->set('field_valor', $valor_liquidacion);
$my_article->set('field_barrio_liquidacion', $barrio_liquidacion);

$my_article->set('field_direccion_correspondencia_', $dir_correspondecia_contrib);
$my_article->set('field_direccion_del_predio', $direccion_evento);


$my_article->set('field_valor_evento', $valor_evento);
$my_article->set('field_valor_letras', $valor_letras);
$my_article->set('field_descripcion_evento', $descripcion_evento );

$my_article->set('field_tipo_de_solicitante', $tipo_solicitante);
$my_article->set('field_id_contribuyente', $id_contribuyente);
$my_article->set('field_nombre_contribuyente', $name_contrib);
$my_article->set('field_email_contribuyente', $email_cotrib );
$my_article->set('field_telefono_fijo_contribuyent', $tfijo);
$my_article->set('field_telefono_movil_contribuyen', $tmovil);
$my_article->set('field_estrato_contribuyente', $estrato);
$my_article->set('field_condicion_contribuyente', $condicion);
$my_article->set('status', '0');
$my_article->set('uid', $id_contribuyente);
         $my_article->set('body', '<table>
         <tbody>
           <tr>
             <td rowspan="6"><img alt="logo" data-align="left" data-entity-type="file" data-entity-uuid="b9334170-92bf-459f-9026-cb733a36e550" height="139" src="/EPA/Liquidador/web/sites/default/files/inline-images/sld-icon-left-epa.png" width="221" /></td>
           </tr>
           <tr>
             <td colspan="3">
             <p>Establecimiento Público Ambiental EPA-Cartagena</p>
             </td>
           </tr>
           <tr>
             <td colspan="3">
             <p>Nit 806013999-2</p>
             </td>
           </tr>
           <tr>
             <td colspan="3">
             <p>Subdirección Administrativa y Financiera</p>
             </td>
           </tr>
           <tr>
             <td colspan="3">
             <p>Manga Calle 4 AVENIDA EDIFICIO SEAPORT</p>
             </td>
           </tr>
           <tr>
             <td colspan="3">
             <p>Liquidación No '.$codigo_liquidacion.'</p>
             </td>
           </tr>
           <tr>
           <td ><p>FECHA:</p></td>
           <td  colspan="3">
           <p>'.date("Y/m/d").'</p>
           </td>
         </tr>
         <tr>
         <td colspan="4">
         <p>Liquidación No '.$codigo_liquidacion.'</p>
         </td>
       </tr>
       <tr>
       <td ><p>ASUNTO:</p></td>
       <td  colspan="3">
       <p>EVALUACION DE APROVECHAMIENTO FORESTAL</p>
       </td>
     </tr>
     <tr>
     <td ><p>PETICIONARIO / EMPRESA:</p></td>
     <td  colspan="3">
     <p>'.$name_contrib.'</p>
     </td>
   </tr>
   <tr>
   <td ><p>DIRECCION:</p></td>
   <td  colspan="3">
   <p>'.$dir_correspondecia_contrib.'</p>
   </td>
 </tr>
 <tr>
 <td ><p>CORREO:</p></td>
 <td  colspan="3">
 <p>'.$email_cotrib.'</p>
 </td>
</tr>
<tr>
<td ><p>TELÉFONO:</p></td>
<td  colspan="3">
<p>'.$tmovil.'</p>
</td>
</tr>
           <tr>
             <td><p>VALOR TARIFA SEGÚN RESOLUCIÓN N° 107 de 17 de febrero de 2021 para este monto de proyecto: </p></td>
             <td colspan="3">
             <p>$ '.$valor_tarifa_evento.'</p>
             </td>
           </tr>
           <tr>
             <td><p>VAOR EVENTO</p></td>
             <td>
             <p>'.$valor_evento.'</p>
             </td>
             <td>TOTAL</td>
             <td >
             <p>$ '.$valor_liquidacion.'</p>
             </td>
           </tr>
           <tr>
             <td colspan="4">
             <p>CONSIDERACIONES</p>

             <p>Categorización de profesionales con base en la Resolución 1280 de 2010 del MAVDT y afectados por un factor multiplicador Factor de administración de acuerdo a la resolución 212 de 2004 del MAVDT</p>

             <p>Esta suma deberá&nbsp;consignarse en la Cuenta de Ahorros No. 43300400033-0 del Banco GNB sudameris, a favor del EPA-Cartagena. Para efectos de acreditar la cancelación de los costos indicados, el usuario deberá presentar original del recibo de consignación, y entregar copia</p>

             <p>Favor no hacer retención por ningún concepto, somos no contribuyentes Según Art. 23 Art 369 y Ley 633 de 2000, Art. 5</p>
             </td>
           </tr>
           <tr>
             <td colspan="4">
             <p>CONCEPTO</p>

             <div class="concepto">
             <p class="concepto">LIQUIDACION DE VIAVILIDAD PARA REALIZACIÓN DE EVENTOS,REALIZACIO DE EVENTO CON COSTO DE PROYECTO : '.$valor_evento.'SMLV, SEGÚN SOLICITUD CON RADICADO #'.$codigo_liquidacion.'</p>
             </div>
             </td>
           </tr>
           <tr>
             <td colspan="4">
             <table align="center" border="0" cellpadding="1" cellspacing="0">
               <tbody>
                 <tr>
                   <td><img alt="F1" data-align="center" data-entity-type="file" data-entity-uuid="11c9db46-1272-4dcb-a9e1-31fcdc9e84b8" height="95" src="/EPA/Liquidador/web/sites/default/files/inline-images/firma_1.png" width="201" /></td>
                   <td><img alt="F1" data-align="center" data-entity-type="file" data-entity-uuid="11c9db46-1272-4dcb-a9e1-31fcdc9e84b8" height="96" src="/EPA/Liquidador/web/sites/default/files/inline-images/firma_1.png" width="202" /></td>
                 </tr>
                 <tr>
                   <td>ROSALINA CARAZO</td>
                   <td>SIBILA MELISSA CARREÑO QUIROS</td>
                 </tr>
                 <tr>
                   <td>Elaborado Por</td>
                   <td>Subdirectora administrativa y financiera</td>
                 </tr>
               </tbody>
             </table>

             <p>&nbsp;</p>
             </td>
           </tr>
         </tbody>
       </table>
       ');
       $my_article->body->format = 'full_html';
         $my_article->enforceIsNew();
           $my_article->save();



           /** Obteniendo el id del nodo creado */
           $nid = $my_article->id();

           $url = \Drupal\Core\Url::fromRoute('entity.node.canonical', ['node' => $my_article->id()]);
           $form_state->setRedirectUrl($url);



    $this->messenger()->addStatus($this->t('You specified a title of @title.', ['@title' =>$nid]));
  }

}