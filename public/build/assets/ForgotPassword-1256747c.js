import{d,T as u,c,w as l,o as i,a as t,u as s,Z as p,g as f,t as _,h as w,b as a,e as g,n as y,f as b}from"./app-09798076.js";import{_ as k}from"./GuestLayout.vue_vue_type_script_setup_true_lang-38725c92.js";import{_ as x,a as h}from"./InputLabel.vue_vue_type_script_setup_true_lang-e4a616c9.js";import{P as V}from"./PrimaryButton-d0855d8a.js";import{_ as v}from"./TextInput.vue_vue_type_script_setup_true_lang-c0667514.js";import"./ApplicationLogo-17c7a710.js";import"./_plugin-vue_export-helper-c27b6911.js";const B=a("div",{class:"mb-4 text-sm text-gray-600 dark:text-gray-400"}," Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one. ",-1),N={key:0,class:"mb-4 font-medium text-sm text-green-600 dark:text-green-400"},P=["onSubmit"],C={class:"flex items-center justify-end mt-4"},D=d({__name:"ForgotPassword",props:{status:{}},setup($){const e=u({email:""}),m=()=>{e.post(route("password.email"))};return(o,r)=>(i(),c(k,null,{default:l(()=>[t(s(p),{title:"Forgot Password"}),B,o.status?(i(),f("div",N,_(o.status),1)):w("",!0),a("form",{onSubmit:b(m,["prevent"])},[a("div",null,[t(x,{for:"email",value:"Email"}),t(v,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:s(e).email,"onUpdate:modelValue":r[0]||(r[0]=n=>s(e).email=n),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),t(h,{class:"mt-2",message:s(e).errors.email},null,8,["message"])]),a("div",C,[t(V,{class:y({"opacity-25":s(e).processing}),disabled:s(e).processing},{default:l(()=>[g(" Email Password Reset Link ")]),_:1},8,["class","disabled"])])],40,P)]),_:1}))}});export{D as default};
