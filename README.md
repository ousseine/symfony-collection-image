## Symfony Collection Images

#### L'idée générale
On a deux entités, dans mon exemple j'ai pris : Wedded et Image.
Pour chaque element de Wedded est associé par un ou plusieur images et chaque image
est associé par un seul element Wedded.


Pour faire une collection d'image on va utiliser le `FileType`
au lieu d'utiliser un formulaire externe (comme l'indique 
[la documentation symfony](https://symfony.com/doc/current/form/form_collections.html) 
car le formulaire externe ne va pas uploader le fichier mais plutot nous 
donner un objet Image vide)

On va utiliser la collection pour l'ajout d'image pour un element Wedded avec l'upload
d'image (voir l'action form sur WeddingController et la documentation symfony) et 
pour la modification et la suppression d'un element Wedded, pour les images 
on va utiliser l'upload d'image simplement (voir l'action add de ImageController)


J'ai mis en place ce projet car j'ai eu du mal a trouvé une solution sur
la collection d'image sur Symfony. En esperant aider ceux qui en ont besoin.