pipeline {
  agent any

  environment {
    GIT_REPO   = "https://github.com/abhishektiwaritwr/sg-events.git"
    GIT_BRANCH = "develop"
    DOCKER_IMAGE = "sg-events-app"
    DOCKER_USER  = "abhishek892"
    IMAGE_NAME   = "\${DOCKER_USER}/\${DOCKER_IMAGE}:latest"
  }

  stages {
    stage('Checkout') {
      steps {
        git branch: "\${GIT_BRANCH}", url: "\${GIT_REPO}"
      }
    }

    stage('Build Docker Image') {
      steps {
        sh 'pwd && ls -la'
        sh 'docker build -t \${DOCKER_IMAGE}:latest -f Dockerfile .'
      }
    }

    stage('Login to DockerHub') {
      steps {
        withCredentials([usernamePassword(credentialsId: 'dockerhub-creds',
                                          usernameVariable: 'DH_USER',
                                          passwordVariable: 'DH_PASS')]) {
          sh 'echo "$DH_PASS" | docker login -u "$DH_USER" --password-stdin'
        }
      }
    }

    stage('Tag and Push Image') {
      steps {
        sh '''
          docker tag \${DOCKER_IMAGE}:latest \${IMAGE_NAME}
          docker push \${IMAGE_NAME}
        '''
      }
    }

    stage('Create imagePullSecret (optional)') {
      steps {
        withCredentials([usernamePassword(credentialsId: 'dockerhub-creds',
                                          usernameVariable: 'KH_USER',
                                          passwordVariable: 'KH_PASS')]) {
          sh '''
            kubectl create secret docker-registry dockerhub-secret \
              --docker-server=https://index.docker.io/v1/ \
              --docker-username="$KH_USER" \
              --docker-password="$KH_PASS" \
              --dry-run=client -o yaml | kubectl apply -f -
          '''
        }
      }
    }

    stage('Deploy to Kubernetes') {
      steps {
        sh 'kubectl apply -f k8s/deployment.yml'
        sh 'kubectl apply -f k8s/service.yml'
      }
    }

    stage('Smoke Tests & Rollout') {
      steps {
        sh 'kubectl rollout status deployment/sg-events-app --timeout=120s || true'
        sh 'kubectl get pods -l app=sg-events-app -o wide'
      }
    }
  }

  post {
    always { sh 'docker logout || true' }
  }
}
