
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

package com.shahba.mobile.entity;

/**
 *
 * @author Anis
 */
public class commande {
    
    private int ref;
    private user client;
    private float prixTotal;
    private String adresse;
    private String description_adresse;
    private String gouvernorat;
    private int codeP;
    private int tel;
    private String nom;
    private String prenom;

    public commande(int ref, String adresse, String description_adresse, int tel, String nom, String prenom) {
        this.ref = ref;
        this.adresse = adresse;
        this.description_adresse = description_adresse;
        this.tel = tel;
        this.nom = nom;
        this.prenom = prenom;
    }



    
    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getPrenom() {
        return prenom;
    }

    public void setPrenom(String prenom) {
        this.prenom = prenom;
    }

    public commande(int ref, user client, float prixTotal, String adresse, String description_adresse, String gouvernorat, int codeP, int tel, String nom, String prenom) {
        this.ref = ref;
        this.client = client;
        this.prixTotal = prixTotal;
        this.adresse = adresse;
        this.description_adresse = description_adresse;
        this.gouvernorat = gouvernorat;
        this.codeP = codeP;
        this.tel = tel;
        this.nom = nom;
        this.prenom = prenom;
    }

    public commande(String adresse, String description_adresse, int tel, String nom, String prenom) {
        this.adresse = adresse;
        this.description_adresse = description_adresse;
        this.tel = tel;
        this.nom = nom;
        this.prenom = prenom;
    }
    
    

    public commande(user client, float prixTotal, String adresse, String description_adresse, String gouvernorat, int codeP, int tel, String nom, String prenom) {
        this.client = client;
        this.prixTotal = prixTotal;
        this.adresse = adresse;
        this.description_adresse = description_adresse;
        this.gouvernorat = gouvernorat;
        this.codeP = codeP;
        this.tel = tel;
        this.nom = nom;
        this.prenom = prenom;
    }



    public commande() {
    }

    
    
    @Override
    public String toString() {
        return "commande{" + "ref=" + ref + ", client=" + client + ", prixTotal=" + prixTotal + ", adresse=" + adresse + ", description_adresse=" + description_adresse + ", gouvernorat=" + gouvernorat + ", codeP=" + codeP + ", tel=" + tel + '}';
    }

    
    
    public int getRef() {
        return ref;
    }

    public void setRef(int ref) {
        this.ref = ref;
    }

    public user getClient() {
        return client;
    }

    public void setClient(user client) {
        this.client = client;
    }

    public float getPrixTotal() {
        return prixTotal;
    }

    public void setPrixTotal(float prixTotal) {
        this.prixTotal = prixTotal;
    }

    public String getAdresse() {
        return adresse;
    }

    public void setAdresse(String adresse) {
        this.adresse = adresse;
    }

    public String getDescription_adresse() {
        return description_adresse;
    }

    public void setDescription_adresse(String description_adresse) {
        this.description_adresse = description_adresse;
    }

    public String getGouvernorat() {
        return gouvernorat;
    }

    public void setGouvernorat(String gouvernorat) {
        this.gouvernorat = gouvernorat;
    }

    public int getCodeP() {
        return codeP;
    }

    public void setCodeP(int codeP) {
        this.codeP = codeP;
    }

    public int getTel() {
        return tel;
    }

    public void setTel(int tel) {
        this.tel = tel;
    }
    
    
    
    
}
