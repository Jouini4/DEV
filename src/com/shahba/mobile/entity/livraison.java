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
public class livraison {
    private int num;
    private commande commande;
    private String statut;

    public livraison(int num, commande commande, String statut) {
        this.num = num;
        this.commande = commande;
        this.statut = statut;
    }

    public livraison() {
    }
    
    

    public livraison(commande commande, String statut) {
        this.commande = commande;
        this.statut = statut;
    }

    @Override
    public String toString() {
        return "livraison{" + "num=" + num + ", commande=" + commande + ", statut=" + statut + '}';
    }
    
    
    
    public int getNum() {
        return num;
    }

    public void setNum(int num) {
        this.num = num;
    }

    public commande getCommande() {
        return commande;
    }

    public void setCommande(commande commande) {
        this.commande = commande;
    }

    public String getStatut() {
        return statut;
    }

    public void setStatut(String statut) {
        this.statut = statut;
    }
    
    
    
    
    
}

