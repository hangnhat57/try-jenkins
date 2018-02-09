node{
     def gitCredentialsId = "5bad9593-8e80-4d49-9561-cae5564223d8";
     def gitRepository = "https://github.com/hangnhat57/try-jenkins.git";
     def gitBranch = "master";
    stages{
    stage("Clean up") {
        sh 'rm -rf ./*' 
    }    
    stage('Checkout') {
        checkout([$class: 'GitSCM', branches: [[name: "*/"+"${gitBranch}"]], 
        doGenerateSubmoduleConfigurations: false,
        extensions: [], 
        submoduleCfg: [],
        userRemoteConfigs: [[credentialsId: "${gitCredentialsId}", url: "${gitRepository}"]]])
        }
    }    
    try
    {
        
    stage("Prepare") {
            sh 'cp .env.example .env'
            sh 'curl -Ol https://getcomposer.org/download/1.6.3/composer.phar'
            sh 'php composer.phar install'  
            sh 'php artisan key:generate'
        }
    stage("Unit test") {
            sh 'vendor/bin/phpunit'
        }
    stage("Deploy"){
        zip archive: true, dir: './', glob: '', zipFile: 'artifact.zip'
        sh 'mkdir target'
        sh 'cp ./artifact.zip ./target/artifact.zip'
        }    
    }
    catch(error) 
    {
        stage("report error") {
            setBuildStatus('Built failed!', 'FAILURE')
            currentBuild.result = 'FAILURE'
            
        }
        throw error
    }

}






// def getWorkspace() {
// 	//fix for branches with '/' in name. See https://issues.jenkins-ci.org/browse/JENKINS-30744
//     pwd().replace("%2F", "_")
// }

// node {
//   ws(getWorkspace()){
//     def gitCredentialsId = "ae2594c4-8fdd-4967-b75b-18cb4b353200";
//     def gitRepository = "https://github.com/hangnhat57/try-jenkins";
   
//   }
//     ``.result = 'SUCCESS'
    
//     stage('Checkout') {
      
//       step([$class: 'WsCleanup', notFailBuild: false])
      
      
//       checkout([$class: 'GitSCM', 
//             branches: [[name: branchName]], 
//             poll: true, 
//             doGenerateSubmoduleConfigurations: false, 
//             extensions: [
//                 [$class: 'GitLFSPull']               
//             ],
//             userRemoteConfigs: [
//                 [credentialsId: "${gitCredentialsId}",
//                  url: "${gitRepository}",
//                  refspec: '+refs/heads/*:refs/remotes/origin/* +refs/pull-requests/*/from:refs/remotes/origin/pr/*'
//                 ]]
//             ])
//     }
//     try{
//      stage("prepare") {
//             sh 'cp .env.example .env'
//             sh 'curl -Ol https://getcomposer.org/download/1.6.3/composer.phar'
//             sh 'php composer.phar install install'  
//             sh 'php artisan key:generate'
//         }
//     stage("phpunit") {
//             sh 'vendor/bin/phpunitt'
//         }
//         setBuildStatus('Built successfully!!!!', 'SUCCESS')
//      } 
//      catch (error) {
//         stage("report error") {
//             setBuildStatus('Built failed!', 'FAILURE')
//             currentBuild.result = 'FAILURE'
//             notifyByMail()
//         }
//         throw error
//      }

// }
void setBuildStatus(String message, String state) {
    step([
        $class: "GitHubCommitStatusSetter",
        reposSource: [$class: "ManuallyEnteredRepositorySource", url: "${gitRepository}" ],
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

// void notifyByMail() {
//     step(
//     mail  cc: 'hangnhat57@gmail.com', 
//     from: 'hangnhat57@gmail.com', replyTo: 'hangnhat57@gmail.com',  
//     to: 'Nhat.nguyen@twentyci.asia',subject: "${currentBuild.result}: ${env.JOB_NAME} [${env.BUILD_NUMBER}]",
//     body: "Please go to ${env.BUILD_URL} for detail!"
//     )
    
// }