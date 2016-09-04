# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
    config.vm.box = "Ubuntu14.04LTS"
    config.vm.box_url = "https://www.dropbox.com/s/gzbxpgjih67uu2t/ubuntu1404lts5018.box?dl=1"
    config.ssh.insert_key = false

    config.hostmanager.enabled				= true
    config.hostmanager.manage_host			= true
    config.hostmanager.manage_guest			= true
    config.hostmanager.ignore_private_ip	= false
    config.hostmanager.include_offline		= true

    config.vm.define "Tico" do |node|
        node.vm.provider "virtualbox" do |vb|
            vb.name = "Tico"
        end
        node.vm.network :private_network, ip: "192.168.56.200"
        node.vm.hostname = 'tico.dev'
        node.hostmanager.aliases = 'www.tico.dev images.tico.dev assets.tico.dev'

        node.vm.provision "chef_solo" do |chef|
            chef.cookbooks_path = "./vendor/rebel-l/sisa/cookbooks"
            chef.roles_path = "./vendor/rebel-l/sisa/roles"
            chef.environments_path = "./vendor/rebel-l/sisa/environments"
            chef.data_bags_path = "./vendor/rebel-l/sisa/data_bags"
            chef.environment = "development"
            chef.add_role "TiCo"

            chef.json = {
                'projects' => [
                    {
                        'name'			=> 'tico',
                        'type'			=> 'php-simple',
                        'server_name'	=> 'tico.dev',
                        'root'			=> '/vagrant/public',
                        'index'			=> 'index.php'
                    }
                ]
            }
        end
    end
end
