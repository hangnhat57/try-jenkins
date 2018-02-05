import java.nio.file.CopyOption
import java.nio.file.Files
import java.nio.file.Paths
import java.nio.file.Path
import java.nio.file.StandardCopyOption
import java.nio.file.StandardOpenOption
import java.util.regex.Matcher
import java.util.regex.Pattern


def getWorkspace() {
	//fix for branches with '/' in name. See https://issues.jenkins-ci.org/browse/JENKINS-30744
    pwd().replace("%2F", "_")
}

<<<<<<< HEAD

    currentBuild.result = 'SUCCESS'
    try {
        stage('initial') {
            echo "Hello"
            echo "\n It's me"
        }
        
        stage("prepare") {
=======
node {
  ws(getWorkspace()){
    def gitCredentialsId = "ae2594c4-8fdd-4967-b75b-18cb4b353200";
    def gitRepository = "https://github.com/hangnhat57/try-jenkins.git";
    
    if(env.BRANCH_NAME.startsWith('PR-')){
      currentBuild.result = 'ABORTED'
      print('To avoid dublicate builds Pull Request\'s jobs are disabled right now. I\'s not an error, just workaround to save the resources...')
      return
    }
    
    println "Environment:"
    bat 'set > env.txt' 
	for (String i : readFile('env.txt').split("\r?\n")) {
    	println i
	}
    currentBuild.result = 'SUCCESS'
    try{
    stage('Checkout') {
      
      step([$class: 'WsCleanup', notFailBuild: false])
      
      def branchName = env.BRANCH_NAME
      if(branchName.startsWith('PR-')){
        branchName = 'pr/'+ env.CHANGE_ID
      }
      checkout([$class: 'GitSCM', 
            branches: [[name: branchName]], 
            poll: true, 
            doGenerateSubmoduleConfigurations: false, 
            extensions: [
                [$class: 'GitLFSPull']               
            ],
            userRemoteConfigs: [
                [credentialsId: "${gitCredentialsId}",
                 url: "${gitRepository}",
                 refspec: '+refs/heads/*:refs/remotes/origin/* +refs/pull-requests/*/from:refs/remotes/origin/pr/*'
                ]]
            ])
    }
     stage("prepare") {
>>>>>>> d4b859ec72ec9a2170ae17f6df808da7b557c94b
            sh 'cp .env.example .env'
            sh 'composer install'
            sh 'php artisan key:generate'
        }
        stage("phpunit") {
            sh 'vendor/bin/phpunitt'
        }
<<<<<<< HEAD
        setBuildStatus('Built successfully!', 'SUCCESS')
=======
        setBuildStatus('Built successfully!!!!', 'SUCCESS')
>>>>>>> d4b859ec72ec9a2170ae17f6df808da7b557c94b
     } catch (error) {
        stage("report error") {
            setBuildStatus('Built failed!', 'FAILURE')
            currentBuild.result = 'FAILURE'
            notifyByMail()
        }
        throw error
     }


void setBuildStatus(String message, String state) {
    step([
        $class: "GitHubCommitStatusSetter",
        reposSource: [$class: "ManuallyEnteredRepositorySource", url: REPO_URL ],
        contextSource: [$class: "ManuallyEnteredCommitContextSource", context: "Jenkins"],
        errorHandlers: [[$class: "ChangingBuildStatusErrorHandler", result: "UNSTABLE"]],
        statusResultSource: [
            $class: "ConditionalStatusResultSource",
            results: [
                [ $class: "AnyBuildResult", message: message, state: state ]
            ]
        ]
    ]);
}

void notifyByMail() {
    emailext (
        to: NOTIFY_TO,
        subject: "${currentBuild.result}: ${env.JOB_NAME} [${env.BUILD_NUMBER}]",
        body: "Please go to ${env.BUILD_URL} for detail!"
    )
}