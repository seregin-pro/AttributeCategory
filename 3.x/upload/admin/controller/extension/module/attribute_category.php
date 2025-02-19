<?php
class ControllerExtensionModuleAttributeCategory extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/attribute_category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') and $this->validate()) {
			$this->model_setting_setting->editSetting('module_attribute_category', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/attribute_category', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/attribute_category', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		
		if (isset($this->request->post['module_attribute_category_show'])) {
			$data['module_attribute_category_show'] = $this->request->post['module_attribute_category_show'];
		} else {
			$data['module_attribute_category_show'] = $this->config->get('module_attribute_category_show');
		}
		
		if (isset($this->request->post['module_attribute_category_title'])) {
			$data['module_attribute_category_title'] = $this->request->post['module_attribute_category_title'];
		} else {
			$data['module_attribute_category_title'] = $this->config->get('module_attribute_category_title');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/attribute_category', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/attribute_category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	
	public function install() {
		$this->load->model('extension/module/attribute_category');
		$this->model_extension_module_attribute_category->createColumns();
	}
}