# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
    config.vm.box = "Ubuntu14"
    config.vm.box_url = "https://www.dropbox.com/s/gzbxpgjih67uu2t/ubuntu1404lts5018.box?dl=1"
    config.ssh.insert_key = false

    config.hostmanager.enabled				= true
    config.hostmanager.manage_host			= true
    config.hostmanager.manage_guest			= true
    config.hostmanager.ignore_private_ip	= false
    config.hostmanager.include_offline		= true

    config.vm.network "private_network", ip: "192.168.56.200"
    config.vm.hostname = 'tico.dev'

    config.vm.provision "chef_solo" do |chef|
        chef.cookbooks_path = "./vendor/rebel-l/sisa/cookbooks"
        chef.roles_path = "./vendor/rebel-l/sisa/roles"
        chef.environments_path = "./vendor/rebel-l/sisa/environments"
        chef.data_bags_path = "./vendor/rebel-l/sisa/data_bags"
        chef.environment = "development"
        chef.add_role "Default"
        chef.add_recipe "NodeJs"
        chef.add_recipe "Php::composer"

        chef.json = {
            'Iptables' => {
                'WEBSERVER'		=> 'On'
            }
        }
    end
end
