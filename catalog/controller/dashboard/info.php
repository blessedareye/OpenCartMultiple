<?php
class ControllerDashboardInfo extends Controller {

    public function index() {

        $this->load->language('dashboard/info');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('dashboard/shop');

        if($this->request->server['REQUEST_METHOD'] == 'POST'){
                $this->model_dashboard_shop->editShopInfo($this->customer->getId(),$this->request->post);
        }

        $data = $this->model_dashboard_shop->getShopInfo($this->customer->getId());

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_form'] =  $this->language->get('text_edit');
        $data['entry_name'] =  $this->language->get('shop_name');
        $data['entry_about'] =  $this->language->get('owner_about');
        $data['entry_about_des'] =  $this->language->get('owner_about_des');
        $data['entry_owner'] =  $this->language->get('owner_name');
        $data['entry_owner_des'] =  $this->language->get('owner_name_des');
        $data['entry_facebook'] =  $this->language->get('facebook_link');
        $data['entry_facebook_des'] =  $this->language->get('facebook_link_des');
        $data['entry_twitter'] =  $this->language->get('twitter_link');
        $data['entry_twitter_des'] =  $this->language->get('twitter_link_des');
        $data['entry_instagram'] =  $this->language->get('instagram_link');
        $data['entry_instagram_des'] =  $this->language->get('instagram_link_des');
        $data['entry_image'] =  $this->language->get('owner_image');
        $data['button_save'] =  $this->language->get('button_save');


        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('dashboard/dashboard','', true)
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('dashboard/info', '', true)
        );

        if (isset($this->error['warning'])) {
                $data['error_warning'] = $this->error['warning'];
        } else {
                $data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
                $data['error_name'] = $this->error['name'];
        } else {
                $data['error_name'] = '';
        }

        //image
        $this->load->model('tool/image');
        $data['action'] = $this->url->link('dashboard/info', '', true);
        if($data['owner_img'] == ""){
            $data['owner_img_url'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }else{
            $data['owner_img_url'] = QINIU_BASE.$data['owner_img']."!thumb";
        }
        if($data['banner_img'] == ""){
            $data['banner_img_url'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }else{
            $data['banner_img_url'] = QINIU_BASE.$data['banner_img']."!thumb";
        }

        // qiniu
        $this->load->model('tool/file');
        $data['qiniu_token'] = $this->model_tool_file->getQiniuToken();
        $data['img_dir'] = floor($this->customer->getId()/1000)."/".$this->customer->getId()."/";

        $data['footer'] = $this->load->controller('dashboard/layoutfooter');
        $data['header'] = $this->load->controller('dashboard/layoutheader');
        $data['column_left'] = $this->load->controller('dashboard/layoutleft');
        $this->response->setOutput($this->load->view('dashboard/info', $data));
    }

}
