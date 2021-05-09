/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

package com.shahba.mobile.entity;

/**
 *
 * @author HAMMOUDA
 */
public class user {
       private int id ;
        private String email;
        private String roles ;
        private String password ;
        private String username ;
        private int userphone ;
        private String useradress;
        private int usercin ;
        private String activation_token ;
        private String reset_token ;

    public user(String email, String roles, String password, String username, int userphone, String useradress, int usercin, String activation_token, String reset_token) {
        this.email = email;
        this.roles = roles;
        this.password = password;
        this.username = username;
        this.userphone = userphone;
        this.useradress = useradress;
        this.usercin = usercin;
        this.activation_token = activation_token;
        this.reset_token = reset_token;
    }

    public user(int id, String email, String roles, String password, String username, int userphone, String useradress, int usercin) {
        this.id = id;
        this.email = email;
        this.roles = roles;
        this.password = password;
        this.username = username;
        this.userphone = userphone;
        this.useradress = useradress;
        this.usercin = usercin;
    }

    public user(String email, String roles, String password, String username, int userphone, String useradress, int usercin) {
        this.email = email;
        this.roles = roles;
        this.password = password;
        this.username = username;
        this.userphone = userphone;
        this.useradress = useradress;
        this.usercin = usercin;
    }

    public user() {
    }

    public user(int id) {
        this.id = id;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getRoles() {
        return roles;
    }

    public void setRoles(String roles) {
        this.roles = roles;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public int getUserphone() {
        return userphone;
    }

    public void setUserphone(int userphone) {
        this.userphone = userphone;
    }

    public String getUseradress() {
        return useradress;
    }

    public void setUseradress(String useradress) {
        this.useradress = useradress;
    }

    public int getUsercin() {
        return usercin;
    }

    public void setUsercin(int usercin) {
        this.usercin = usercin;
    }

    public String getActivation_token() {
        return activation_token;
    }

    public void setActivation_token(String activation_token) {
        this.activation_token = activation_token;
    }

    public String getReset_token() {
        return reset_token;
    }

    public void setReset_token(String reset_token) {
        this.reset_token = reset_token;
    }
        
        

}
