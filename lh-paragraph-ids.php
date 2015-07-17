<?php
/*
Plugin Name: LH Paragraph IDs
Plugin URI: http://lhero.org/plugins/lh-paragraph-ids/
Description:  This plug-in adds a customizable, 'id' attribute to your <p> tags on singular posts. This enables links to specific paragraphs in your posts and pages.  
Author: Peter Shaw
Version: 1.0
Author URI: http://shawfactor.com
*/

/*  Copyright 2015 Peter Shaw (email : pete [at] localhero [dot] biz )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/



/*
*  LH Paragraph IDs class
*
*  @description:
*/
class LH_paragraph_ids_plugin {

var $filename;

    protected $count = 0;


    
    /*
    *  Build
    *
    *  @description: 
    */
    public function scan( $start_pattern, $end_pattern, $content ) {	

		if (get_option('lh_paragragraph_ids_enabled')) {
            // Scan the content for the start pattern
    		$this->count = 0;
            $content = preg_replace_callback( $start_pattern, array( $this, 'insertID' ), $content );
        }


        return $content; 

    }


    /*
    *  gatherClass
    *
    *  @description: 
    */
    public function gatherClass() {
        $classes = array('lh-paragraph-id');

        return $classes;   

    }


    /*
    *  insertID
    *
    *  @description: 
    */
	public function insertID( $matches ) {
        
        $postid = get_the_ID(); 
        $this->count++;

        $classes = $this->gatherClass();
       
        return '<p class="' . implode($classes, ' ') . '" id="' . get_option('lh_paragragraph_ids_prefix') . $postid . '-' . $this->count . '">'; 

    }	




    /*
    *  para_ids_content_filter
    *
    *  @description: 
    */
    public function para_ids_content_filter( $content ){



        if ((is_singular()) and (!is_admin()) ) {

            
            return $this->scan( '~<p>~', '~</p>~', $content ); 

        } else { 

            return $content; 
        } 
    }


public function load_js() {
    
    wp_register_script( 'lh-paragraph-ids-js', plugins_url('scripts/lh-paragraph-ids.js', __FILE__), '', '0.13', true);

    if (is_singular()) {

if (get_option('lh_paragragraph_ids_anchor_enabled')){
        
        wp_enqueue_script('lh-paragraph-ids-js');

}

    }

}

public function plugin_menu() {
    add_options_page('LH Paragraph IDs Settings', 'LH Paragraph IDs', 'manage_options', $this->filename, array($this,"plugin_options"));
}

public function plugin_options() { ?>

    <div class="wrap">
        <div id="icon-options-general" class="icon32"><br /></div>
        <h2>LH Paragraph IDs</h2>
        <p>Conceived by <strong><a href="http://shawfactor.com" title="Visit my website">Peter Shaw</a></strong></p>

        <p>This plugin adds paragraph level IDs to your post content.</p>
        
        <p><em>Note:  This plugin only acts on a simple <code>&lt;p&gt;</code> tag with no attributes.</em></p>
     
        <form method="post" action="options.php">
        <?php settings_fields('lh_paragragraph_ids_optiongroup'); ?>
        
            <h3>Paragraph IDs</h3>
            <p>Check this box to add an 'id' attribute to each paragraph tag in your content. You can choose an optional prefix if you wish.</p>
            <input type="checkbox" name="lh_paragragraph_ids_enabled" value="1" <?php checked( get_option('lh_paragragraph_ids_enabled'), 1 ); ?> />
            <label for="lh_paragragraph_ids_enabled">Enable</label><br />
            <input name="lh_paragragraph_ids_prefix" type="text" id="lh_paragragraph_ids_prefix" placeholder="Your custom prefix" value="<?php echo get_option('lh_paragragraph_ids_prefix'); ?>" class="regular-text" />

            <h3>Anchors</h3>
            <p>Check this box to add # links immediately after each paragraph tag in your content. This will enable readers to quickly share a section of your article.</p>
            <input type="checkbox" name="lh_paragragraph_ids_anchor_enabled" value="1" <?php checked( get_option('lh_paragragraph_ids_anchor_enabled'), 1 ); ?> />
            <label for="lh_paragragraph_ids_anchor_enabled">Enable</label><br />        
            <p>NOTE: Paragraph IDs must also be enabled for the anchors to work</p>


            <p class="submit">
              <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
            </p>		
        </form>
        
        <h3>Preview</h3>
       
        <p>This is how each paragraph in your markup will begin.  Remember this only applies to <strong>single posts</strong>, not the archives or home page.  If you see XXX or YY in the example below, those letters will be replaced with numbers relating to the post ID and paragraph number.</p>
        <p><code><?php if(get_option('lh_paragragraph_ids_anchor_enabled')) { ?><?php } ?>&lt;p<?php if(get_option('lh_paragragraph_ids_enabled')) { ?> id="<?php echo get_option('lh_paragragraph_ids_prefix'); ?>XXX-YY"<?php } ?>&gt;</code></p>
    </div><?php } // end if (is_admin())


public function ids_register() {
    register_setting('lh_paragragraph_ids_optiongroup', 'lh_paragragraph_ids_enabled');
    register_setting('lh_paragragraph_ids_optiongroup', 'lh_paragragraph_ids_prefix');
    register_setting('lh_paragragraph_ids_optiongroup', 'lh_paragragraph_ids_anchor_enabled');
}

// add a settings link next to deactive / edit
public function add_settings_link( $links, $file ) {

	if( $file == $this->filename ){
		$links[] = '<a href="'. admin_url( 'options-general.php?page=' ).$this->filename.'">Settings</a>';
	}
	return $links;
}



    /*
    *  Constructor
    *
    *  @description: This method will be called each time this object is created
    */

public function __construct() {

$this->filename = plugin_basename( __FILE__ );

add_filter( 'the_content', array($this, 'para_ids_content_filter'), 100 );

add_action('admin_menu', array($this,"plugin_menu"));

add_action( 'wp_enqueue_scripts', array($this, 'load_js') );

add_action('admin_init', array($this, 'ids_register') );

add_filter('plugin_action_links', array($this,"add_settings_link"), 10, 2);


}


}

$lh_paragraph_ids_instance = new LH_paragraph_ids_plugin();

?>