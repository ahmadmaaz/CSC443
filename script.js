//script to toggle mobile navbar , on click on the burger menu
function toggleMenuMobile(){
    const mobileMenu = document.getElementById('shopping-cart-container');
    mobileMenu.classList.toggle('hidden');
}

document.getElementById('shopping-cart-icon')?.addEventListener('click',toggleMenuMobile);
document.getElementById('shopping-cart-trigger')?.addEventListener('click',toggleMenuMobile);


document.querySelector('.img-btn').addEventListener('click', function()
	{
		document.querySelector('.cont').classList.toggle('s-signup')
	}
);
