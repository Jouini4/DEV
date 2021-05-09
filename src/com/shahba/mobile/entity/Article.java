/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.shahba.mobile.entity;

/**
 *
 * @author ASUS
 */
public class Article {
    private int id;
    private int categorie_id;
    private String nom_produit;
    private String description;
    private String image;
    private float prix;
    private int likes;
    private String nom_categorie;

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getCategorie_id() {
        return categorie_id;
    }

    public void setCategorie_id(int categorie_id) {
        this.categorie_id = categorie_id;
    }

    public String getNom_produit() {
        return nom_produit;
    }

    public void setNom_produit(String nom_produit) {
        this.nom_produit = nom_produit;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public String getImage() {
        return image;
    }

    public void setImage(String image) {
        this.image = image;
    }

    public float getPrix() {
        return prix;
    }

    public void setPrix(float prix) {
        this.prix = prix;
    }

    public int getLikes() {
        return likes;
    }

    public void setLikes(int likes) {
        this.likes = likes;
    }

    public String getNom_categorie() {
        return nom_categorie;
    }

    public void setNom_categorie(String nom_categorie) {
        this.nom_categorie = nom_categorie;
    }

    @Override
    public String toString() {
        return "Article{" + "id=" + id + ", categorie_id=" + categorie_id + ", nom_produit=" + nom_produit + ", description=" + description + ", image=" + image + ", prix=" + prix + ", likes=" + likes + ", nom_categorie=" + nom_categorie + '}';
    }

    public Article() {
    }

    public Article(int id, int categorie_id, String nom_produit, String description, String image, float prix, int likes, String nom_categorie) {
        this.id = id;
        this.categorie_id = categorie_id;
        this.nom_produit = nom_produit;
        this.description = description;
        this.image = image;
        this.prix = prix;
        this.likes = likes;
        this.nom_categorie = nom_categorie;
    }

    public Article(int categorie_id, String nom_produit, String description, String image, float prix, int likes, String nom_categorie) {
        this.categorie_id = categorie_id;
        this.nom_produit = nom_produit;
        this.description = description;
        this.image = image;
        this.prix = prix;
        this.likes = likes;
        this.nom_categorie = nom_categorie;
    }

    public Article(String nom_produit, String description, String image, float prix, int likes, String nom_categorie) {
        this.nom_produit = nom_produit;
        this.description = description;
        this.image = image;
        this.prix = prix;
        this.likes = likes;
        this.nom_categorie = nom_categorie;
    }
    
     public Article(String nom_produit, String description, String image, float prix, String nom_categorie,int id) {
        this.id = id;
        this.nom_produit = nom_produit;
        this.description = description;
        this.image = image;
        this.prix = prix;
 
        this.nom_categorie = nom_categorie;
    }

    public Article(String nom_produit, String description, String image, float prix, String nom_categorie) {
        this.nom_produit = nom_produit;
        this.description = description;
        this.image = image;
        this.prix = prix;
        this.nom_categorie = nom_categorie;
    }

    public Article(String nom_produit, String description, String image, float prix, int likes) {
        this.nom_produit = nom_produit;
        this.description = description;
        this.image = image;
        this.prix = prix;
        this.likes = likes;
    }





   
    
    
}

