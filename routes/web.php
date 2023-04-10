<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SitePageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeSliderController;
use App\Http\Controllers\CountryAreaController;
use App\Http\Controllers\DynamicPageController;
use App\Http\Controllers\StaffMemberController;
use App\Http\Controllers\DonateAccountController;
use App\Http\Controllers\CouncilMemberController;
use App\Http\Controllers\LanguageChangeController;
use App\Http\Controllers\AccountProfileController;
use App\Http\Controllers\MondirAndAshramController;
use App\Http\Controllers\SiteMenuController;

Route::get('/', function () {
    return redirect('/home');
});

Route::get('home', [SitePageController::class, 'homePage'])->name('home');

Route::get('/calender-generate', [SitePageController::class, 'calenderGenerate'])->name('calender.generate');
Route::get('/layout-calender-generate', [SitePageController::class, 'layoutCalenderGenerate'])->name('layout.calender.generate');

Route::prefix('language')->name('language.')->group(function(){
    Route::get('/', [LanguageChangeController::class, 'change'])->name('change');
});

Route::get('page/{slug}', [SitePageController::class, 'dynamicPage'])->name('dynamic.page');

Route::get('{template}/member/branch/{branch}', [SitePageController::class, 'memberDynamicPage'])->name('member.dynamic.page');
Route::get('council-member-info/{id}', [SitePageController::class, 'councilMemberInfoPage'])->name('council.member.info.page');
Route::prefix('gallery')->group(function(){
    Route::get('/image-gallery', [SitePageController::class, 'imageGalleryPage'])->name('image.gallery.page');
    Route::get('/video-gallery', [SitePageController::class, 'videoGalleryPage'])->name('video.gallery.page');
});
Route::get('/medical-service-detail/{id}', [SitePageController::class, 'medicalServiceDetails'])->name('medical.service.details');

Route::post('/send-email', [SitePageController::class, 'sendEmail'])->name('send.email');


Auth::routes(['register' => false,'verify' => true,]);

Route::group(['middleware' => 'prevent.back.history'],function(){

    Route::prefix('admin')->group(function(){
        Route::prefix('dashboard')->name('dashboard.')->group(function(){
            Route::get('/', [DashboardController::class, 'index'])->name('index');
            Route::get('/edit/{settingType}', [DashboardController::class, 'edit'])->name('edit');
            Route::patch('/update/{settingType}', [DashboardController::class, 'update'])->name('update');
        });

        Route::prefix('event')->name('event.')->group(function(){
            Route::get('/', [EventController::class, 'index'])->name('index');
            Route::get('/add', [EventController::class, 'add'])->name('add');
            Route::get('/edit/{id}', [EventController::class, 'edit'])->name('edit');

            Route::post('/save', [EventController::class, 'save'])->name('save');
            Route::patch('/update/{id}', [EventController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [EventController::class, 'delete'])->name('delete');
        });

        Route::prefix('home-slider')->name('home.slider.')->group(function(){
            Route::get('/', [HomeSliderController::class, 'index'])->name('index');
            Route::get('/add', [HomeSliderController::class, 'add'])->name('add');
            Route::get('/edit/{id}', [HomeSliderController::class, 'edit'])->name('edit');

            Route::post('/save', [HomeSliderController::class, 'save'])->name('save');
            Route::patch('/update/{id}', [HomeSliderController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [HomeSliderController::class, 'delete'])->name('delete');
        });

        Route::prefix('gallery')->name('gallery.')->group(function(){
            Route::get('/', [GalleryController::class, 'index'])->name('index');
            Route::get('/add', [GalleryController::class, 'add'])->name('add');
            Route::get('/edit/{id}', [GalleryController::class, 'edit'])->name('edit');

            Route::post('/save', [GalleryController::class, 'save'])->name('save');
            Route::patch('/update/{id}', [GalleryController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [GalleryController::class, 'delete'])->name('delete');
        });

        Route::prefix('donate-account')->name('donate.account.')->group(function(){
            Route::get('/', [DonateAccountController::class, 'index'])->name('index');
            Route::get('/add', [DonateAccountController::class, 'add'])->name('add');
            Route::get('/edit/{id}', [DonateAccountController::class, 'edit'])->name('edit');

            Route::post('/save', [DonateAccountController::class, 'save'])->name('save');
            Route::patch('/update/{id}', [DonateAccountController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [DonateAccountController::class, 'delete'])->name('delete');
        });

        Route::prefix('council-member')->name('council.member.')->group(function(){
            Route::get('/', [CouncilMemberController::class, 'index'])->name('index');
            Route::get('/add', [CouncilMemberController::class, 'add'])->name('add');
            Route::get('/edit/{id}', [CouncilMemberController::class, 'edit'])->name('edit');

            Route::post('/save', [CouncilMemberController::class, 'save'])->name('save');
            Route::patch('/update/{id}', [CouncilMemberController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [CouncilMemberController::class, 'delete'])->name('delete');
        });

        Route::prefix('staff-member')->name('staff.member.')->group(function(){
            Route::get('/', [StaffMemberController::class, 'index'])->name('index');
            Route::get('/add', [StaffMemberController::class, 'add'])->name('add');
            Route::get('/edit/{id}', [StaffMemberController::class, 'edit'])->name('edit');

            Route::post('/save', [StaffMemberController::class, 'save'])->name('save');
            Route::patch('/update/{id}', [StaffMemberController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [StaffMemberController::class, 'delete'])->name('delete');
        });

        Route::prefix('country-area')->name('country.area.')->group(function(){
            Route::get('/', [CountryAreaController::class, 'index'])->name('index');
            Route::get('/add', [CountryAreaController::class, 'add'])->name('add');
            Route::get('/edit/{id}', [CountryAreaController::class, 'edit'])->name('edit');

            Route::post('/save', [CountryAreaController::class, 'save'])->name('save');
            Route::patch('/update/{id}', [CountryAreaController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [CountryAreaController::class, 'delete'])->name('delete');
        });

        Route::prefix('site-menu')->name('site.menu.')->group(function(){
            Route::get('/', [SiteMenuController::class, 'index'])->name('index');
            Route::get('/add', [SiteMenuController::class, 'add'])->name('add');
            Route::get('/edit/{id}', [SiteMenuController::class, 'edit'])->name('edit');

            Route::post('/save', [SiteMenuController::class, 'save'])->name('save');
            Route::patch('/update/{id}', [SiteMenuController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [SiteMenuController::class, 'delete'])->name('delete');
        });

        Route::prefix('mondir-and-ashram')->name('mondir.and.ashram.')->group(function(){
            Route::get('/', [MondirAndAshramController::class, 'index'])->name('index');
            Route::get('/add', [MondirAndAshramController::class, 'add'])->name('add');
            Route::get('/edit/{id}', [MondirAndAshramController::class, 'edit'])->name('edit');

            Route::post('/save', [MondirAndAshramController::class, 'save'])->name('save');
            Route::patch('/update/{id}', [MondirAndAshramController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [MondirAndAshramController::class, 'delete'])->name('delete');
        });

        Route::prefix('account-profile')->name('account.profile.')->group(function(){
            Route::get('/', [AccountProfileController::class, 'index'])->name('index');
            Route::get('/edit', [AccountProfileController::class, 'edit'])->name('edit');

            Route::patch('/update', [AccountProfileController::class, 'update'])->name('update');
        });

        Route::prefix('dynamic-page')->name('dynamic.page.')->group(function(){
            Route::get('/', [DynamicPageController::class, 'index'])->name('index');
            Route::get('/add', [DynamicPageController::class, 'add'])->name('add');
            Route::get('/edit/{id}', [DynamicPageController::class, 'edit'])->name('edit');

            Route::post('/save', [DynamicPageController::class, 'save'])->name('save');
            Route::patch('/update/{id}', [DynamicPageController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [DynamicPageController::class, 'delete'])->name('delete');

            Route::prefix('section')->name('section.')->group(function(){
                Route::get('{id}/', [DynamicPageController::class, 'sectionIndex'])->name('index');
                Route::get('{id}/add', [DynamicPageController::class, 'sectionAdd'])->name('add');
                Route::get('{id}/edit/{sid}', [DynamicPageController::class, 'sectionEdit'])->name('edit');

                Route::post('{id}/save', [DynamicPageController::class, 'sectionSave'])->name('save');
                Route::patch('{id}/update/{sid}', [DynamicPageController::class, 'sectionUpdate'])->name('update');
                Route::delete('{id}/delete/{sid}', [DynamicPageController::class, 'sectionDelete'])->name('delete');
            });
        });
    });

});


