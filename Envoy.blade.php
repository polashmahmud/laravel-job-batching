@servers(['vps' => 'root@104.251.216.142'])

@task('create_folder', ['on' => 'vps'])
    mkdir -p /root/new_folder
    echo "Folder created successfully on server!"
@endtask

