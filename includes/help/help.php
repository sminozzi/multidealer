<?php /**
 * @author Bill Minozzi
 * @copyright 2017
 */
 if( current_user_can('editor')) {
    add_action('current_screen', 'this_screen');
    function this_screen()
    {
        $current_screen = get_current_screen();
        
        // echo $current_screen->id;
        //die();
        
        
        if ($current_screen->id === "edit-multidealerfields") {
            add_filter('contextual_help', 'MultiDealer_contextual_help_fields', 10, 3);
        }
         if ($current_screen->id === "edit-products") {
            add_filter('contextual_help', 'MultiDealer_contextual_help_products', 10, 3);
        } 
         if ($current_screen->id === "edit-makes") {
            add_filter('contextual_help', 'MultiDealer_contextual_help_makes', 10, 3);
        }
        if ($current_screen->id === "edit-locations") {
            add_filter('contextual_help', 'MultiDealer_contextual_help_locations', 10, 3);
        }     
        else {
            if (isset($_GET['page'])) {
                if ($_GET['page'] == 'multi_dealer_plugin') {
                    add_filter('contextual_help', 'MultiDealer_main_help', 10, 3);
                }
            }
        }
    }
}
function MultiDealer_main_help($contextual_help, $screen_id, $screen)
{
    $myhelp = '<br> The easiest way to manage, list and sell yours products online.';
    $myhelp .= '<br />';
    $myhelp .= 'Follow the 3 steps in this main screen after install the plugin. <br />';
    $myhelp .= '<br />';
    $myhelp .= 'You will find Context Help in many screens.';
    $myhelp .= '<br />';
    $myhelp .= 'You can find also our complete OnLine Guide  <a href="http://multidealerplugin.com/guide/" target="_self">here.</a>';
    $screen->add_help_tab(array(
        'id' => 'MultiDealer-overview-tab',
        'title' => __('Overview', 'multidealer'),
        'content' => '<p>' . $myhelp . '</p>',
        ));
    return $contextual_help;
} 
function MultiDealer_contextual_help_fields($contextual_help, $screen_id, $screen)
{
     $myhelp = 'In the FIELDS screen you can manage the main table fields.
    This fields will show up 
    in your main dealer form management, search bar and search widget.
    <br />
    Each row represents one field.
    <br /> 
    For example, if you are a Car Dealer, maybe you want add this fields:
    <br />
    <ul>
    <li>Fuel Type</li>
    <li>Year</li> 
    <li>HP</li>    
    <li>And So On</li>  
    </ul>
    Or, if you are, in Real Estate Business, maybe you want add this fields:
    <ul>
    <li>Bedroom</li>
    <li>Pool</li> 
    <li>Garage</li>    
    <li>And So On</li>  
    </ul>
    <br />
    Technical WordPress guys call this of Metadata.
    <br />
    You don\'t need add this fields:
    <ul>
    <li>Product Name (title)</li>
    <li>Price</li> 
    <li>Featured</li>    
    <li>Year</li>  
    </ul>
    Don\'t create 2 products with the same name.
    <br />
    <br />
    ';
     $myhelpAdd = 'To add fields in the table, click the button Add New. This can open the empty window to include your information:
     <br />
    <ul>
    <li>Field Name</li>
    <li>Field Label</li>
    <li>Field Order</li>
    <li>Show in Search Bar (your frontpage)</li>
    <li>Show in Search Widget (your frontpage)</li>  
    <li>Type of Field</li>    
    <li>And So On</li>  
    </ul>    
    In that screen, move the mouse pointer over each field to get help about that field.
    <br />
    Just fill out and click OK button.
    <br />      
     ';
    $myhelpTypes = 'You have available this types of fields (Control Types):
    <br />
    <ul>
    <li>Text (Used by text and numbers)</li>
    <li>CheckBox</li>
    <li>Drop Down (also called select box)</li> 
    <li>Google Map (For example: usefull in Real Estate business)</li> 
    <li>Range Select (you can define de value min, max and step)</li>    
    <!-- <li>Range Slider (you can define de value min, max and step)</li>  -->
    </ul>    
    <br />
    For more details about HTML input types, please, check this page:
<a href="https://www.w3schools.com/html/html_form_input_types.asp ">https://www.w3schools.com/html/html_form_input_types.asp 
</a>
   <br />
'; 
    $myhelpEdit = 'You can manage the table, i mean, Add, Edit and Trash Fields.
    <br />
    At the Add Fields and Edit Fields forms, put the mouse over each row and the menu show up. Then, click over Edit or Trash.
    <br />
    To know more about Edit Fields, please, check the Add Fields Form Option at this help menu.
     ';  
    $screen->add_help_tab(array(
        'id' => 'MultiDealer-overview-tab',
        'title' => __('Overview', 'multidealer'),
        'content' => '<p>' . $myhelp . '</p>',
        ));
      $screen->add_help_tab(array(
        'id' => 'MultiDealer-field-types',
        'title' => __('Field Types', 'multidealer'),
        'content' => '<p>' . $myhelpTypes . '</p>',
        ));   
     $screen->add_help_tab(array(
        'id' => 'MultiDealer-overview-add',
        'title' => __('Add Fields Form', 'multidealer'),
        'content' => '<p>' . $myhelpAdd . '</p>',
        )); 
     $screen->add_help_tab(array(
        'id' => 'MultiDealer-field-edit',
        'title' => __('Edit and Trash Fields', 'multidealer'),
        'content' => '<p>' . $myhelpEdit . '</p>',
        ));      
    return $contextual_help;
} 
function MultiDealer_contextual_help_products($contextual_help, $screen_id, $screen)
{
    $myhelp = 'In the PRODUCTS screen you can manage (include, edit or delete) items in your Products Table.
    This products will show up in your site front page.
    <br />
    We suggest you take some time to complete your Field table before this step.
    <br />
    Dashboard => MultiDealer => Fields Table.
    <br />
    You will find some fields automatically included by the system (Title, Price, Featured and Year).
    Just add your products in this table.
    <br />
    If you are a car dealer, for example, you can add:
    <ul>
    <li>Title: Ford</li>
    <li>Year: 2017</li>
    <li>Price: 15000</li>
    <li>and so on ...</li>
    </ul>
    ';
     $myhelpAdd = 'To add fields in the table, click the button Add New. This can open the empty window to include your information:
     <br />
    <ul>
    <li>Field Name</li>
    <li>Field Label</li>
    <li>Field Order</li>
    <li>Show in Search Bar (your frontpage)</li>
    <li>Show in Search Widget (your frontpage)</li>  
    <li>Type of Field</li>    
    <li>And So On</li>  
    </ul>    
    In that screen, move the mouse pointer over each field to get help about that field.
    <br />
    Just fill out and click OK button.
    <br />      
     ';
    $myhelpMakes = 'Use the Makes control it is optional. To add new makes, go to:
    <br />
    Dashboard=> Multi Dealer => Makes
    <br />  
    If you are, for example, a car dealer, maybe you want add: 
    <ul>
    <li>Ford</li>
    <li>Chevrolet</li>
    <li>And So On...</li> 
    </ul>    
    <br />
    <br />
'; 
    $myhelpLocation = 'Use the Location control it is optional. Maybe you want use it if you have more than one location.
    To add new locations, go to:
    <br />
    Dashboard=> Multi Dealer => Locations
    <br />  
    If you are, for example, in Florida, maybe you want add: 
    <ul>
    <li>Fort Lauderdale</li>
    <li>Miami</li>
    <li>And So On...</li> 
    </ul>    
    <br />
   <br />
'; 
    $myhelpEdit = 'You can manage the table, i mean, Add, Edit and Trash Products.
    <br />
    Use the Add New Buttom or to Edit, put the mouse over each row and the menu will show up. Then, click over Edit or Trash.
    <br />
     ';  
    $myhelpFeatured = 'You can add one main image to each product. 
    In the Products Form, click the button Set Featured Image at bottom right corner.
    <br />
    <br />
     '; 
    $myhelpGallery = 'You can add Images or one gallery for each product.
    Just go to Product Form and add the images (or the gallery) in the main description field and click the Add Media buttom. 
    <br />
     ';     
    $screen->add_help_tab(array(
        'id' => 'MultiDealer-overview-tab',
        'title' => __('Overview', 'multidealer'),
        'content' => '<p>' . $myhelp . '</p>',
        ));
      $screen->add_help_tab(array(
        'id' => 'MultiDealer-products-makes',
        'title' => __('Makes', 'multidealer'),
        'content' => '<p>' . $myhelpMakes . '</p>',
        ));   
     $screen->add_help_tab(array(
        'id' => 'MultiDealer-products-location',
        'title' => __('Location', 'multidealer'),
        'content' => '<p>' . $myhelpLocation . '</p>',
        )); 
     $screen->add_help_tab(array(
        'id' => 'MultiDealer-products-edit',
        'title' => __('Edit and Trash Products', 'multidealer'),
        'content' => '<p>' . $myhelpEdit . '</p>',
        ));
     $screen->add_help_tab(array(
        'id' => 'MultiDealer-products-featured',
        'title' => __('Featured Images', 'multidealer'),
        'content' => '<p>' . $myhelpFeatured . '</p>',
        ));
     $screen->add_help_tab(array(
        'id' => 'MultiDealer-products-gallery',
        'title' => __('Images Gallery', 'multidealer'),
        'content' => '<p>' . $myhelpGallery . '</p>',
        ));           
    return $contextual_help;
} 
function MultiDealer_contextual_help_makes($contextual_help, $screen_id, $screen)
{
    $myhelpMakes = 'Use the Makes table it is optional. 
    <br />  
    If you are, for example, a car dealer, maybe you want add: 
    <ul>
    <li>Ford</li>
    <li>Chevrolet</li>
    <li>And So On...</li> 
    </ul>    
    <br />
';
    $screen->add_help_tab(array(
        'id' => 'MultiDealer-overview-tab',
        'title' => __('Overview', 'multidealer'),
        'content' => '<p>' . $myhelpMakes . '</p>',
        ));
    return $contextual_help;
}
function MultiDealer_contextual_help_locations($contextual_help, $screen_id, $screen)
{
    $myhelpLocation = 'Use the Location table it is optional. Maybe you want use it if you have more than one location.
    <br />  
    If you are, for example, in Florida, maybe you want add: 
    <ul>
    <li>Fort Lauderdale</li>
    <li>Miami</li>
    <li>And So On...</li> 
    </ul>    
   <br />
';
    $screen->add_help_tab(array(
        'id' => 'MultiDealer-overview-tab',
        'title' => __('Overview', 'multidealer'),
        'content' => '<p>' . $myhelpLocation . '</p>',
        ));
     return $contextual_help;
}
?>