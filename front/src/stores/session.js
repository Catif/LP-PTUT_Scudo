import { defineStore } from 'pinia'
import { reactive } from 'vue';
import { useRouter } from 'vue-router';

export const useSessionStore = defineStore('session', () => {
  const router = useRouter();
  const data = reactive({
    idUser: '',
    token: '',
  })

  function setSession(t, idUser){
    data.token = t;
    data.idUser = idUser;
  }
  
  function emptySession(){
    data.token = '';
    router.push('/login')
  }

  return { data, setSession, emptySession }
}, {
  persist: true,
})
