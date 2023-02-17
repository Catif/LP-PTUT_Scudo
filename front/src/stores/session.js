import { defineStore } from 'pinia'
import { reactive } from 'vue';

export const useSessionStore = defineStore('session', () => {
  const data = reactive({
    token: ''
  })

  function setSession(t){
    data.token = t;
  }
  
  function emptySession(){
    data.token = '';
  }

  return { data, setSession, emptySession }
}, {
  persist: true,
})
