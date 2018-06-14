function CustomModal(idModal)
{
    this.modal = $('#'+idModal);
    this.modalContent = this.modal.find('.customModalContent');
    this.modalContent.hide();
    this.closeBtns = document.getElementsByClassName("customModalCloseBtn");
    this.init();
}

CustomModal.prototype.init = function ()
{
    this.btnCloseOnClick();
};

CustomModal.prototype.close = function ()
{
    //this.modal.style.display = "none";
    this.modalContent.slideUp("slow");
    this.modal.hide(500);
};
CustomModal.prototype.open = function ()
{
    //this.modal.style.display = "block";
    this.modal.slideDown("slow");
    this.modalContent.slideDown("slow");
};
CustomModal.prototype.btnCloseOnClick = function ()
{
    var self = this;
    for (var i = 0; i < self.closeBtns.length; i++)
    {
        self.closeBtns[i].onclick = function ()
        {
            self.close();
        }
    }
};