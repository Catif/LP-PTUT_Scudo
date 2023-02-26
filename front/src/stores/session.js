import { defineStore } from 'pinia'
import { reactive } from 'vue';
import { useRouter } from 'vue-router';

export const useSessionStore = defineStore('session', () => {
  const router = useRouter();
  const data = reactive({
    token: ''
  })

  function setSession(t){
    data.token = t;
  }
  
  function emptySession(){
    data.token = '';
    router.push('/login')
  }

  return { data, setSession, emptySession }
}, {
  persist: true,
})
