node {
    switch(env.BRANCH_NAME) {
      case "develop":
        branch = "Dev"
        break
      case "master":
        branch = "Master"
        break
    }
}

pipeline {
    agent any
    stages {
        stage('Build') {
            steps {
                script {
                        try {
                            bash "composer install"
                        } catch (Exception e) {
                            e = "<code>\u274C ERROR(${env.BRANCH_NAME} backend branch): BUILD ERROR</code>"
                            bash "curl 'https://api.telegram.org/bot705294643:AAGnXC6EzmrpXU4USD6uxq7U1Qt853s4ciYz/sendMessage?chat_id=-211246197@Avakada_CI&text=${e}&parse_mode=HTML'"
                            throw ex
                        }
                    }
            }
        }
        stage('Delivery') {
            steps {
                script {
                        try {
                            bash "rm -rf /home/makeperfectby/Assembly/${branch}/Back/Code/*"
                            bash "cp -r * /home/makeperfectby/Assembly/${branch}/Back/Code/"
                        } catch (ex) {
                            e = "<code>\u274C ERROR(${env.BRANCH_NAME} backend branch): DELIVERY ERROR</code>"
                            bash "curl 'https://api.telegram.org/bot705294643:AAGnXC6EzmrpXU4USD6uxq7U1Qt853s4ciYz/sendMessage?chat_id=-211246197@Avakada_CI&text=${e}&parse_mode=HTML'"
                            throw ex
                        }
                    }
            }
        }
        stage('Notification') {
            steps {
                script {
                    mes = "<pre>\u2705 BACKEND (${env.BRANCH_NAME})</pre>"
                    bash "curl 'https://api.telegram.org/bot705294643:AAGnXC6EzmrpXU4USD6uxq7U1Qt853s4ciYz/sendMessage?chat_id=-211246197@Avakada_CI&text=${mes}&parse_mode=HTML'"
                }
            }
        }
    }
}
