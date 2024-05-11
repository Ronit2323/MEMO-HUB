<?php

use App\Http\Controllers\association;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\moderatorController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FavoriteController;
use App\Models\Moderator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'verify'=>true
]);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');
Route::post('/contact-submit', [App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');


Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');


Route::get('/user/{userId}/notes', [NoteController::class, 'showUserNotes'])->name('user.notes');

Route::get('/discussion', [ChatController::class, 'index'])->name('chat');
Route::resource('categorys', 'App\Http\Controllers\CategoryController');
Route::resource('subjects', 'App\Http\Controllers\subjectController');
Route::resource('facultys', 'App\Http\Controllers\FacultyController');
Route::resource('notes', 'App\Http\Controllers\NoteController');
Route::resource('subscriptions', 'App\Http\Controllers\SubscriptionController');
Route::get('/searchNote', [NoteController::class, 'searchApprovedNotes'])->name('searchNote');
Route::post('/like/{note}', [NoteController::class, 'like'])->name('like');
Route::match(['get', 'post'], '/viewNote/{note}', [NoteController::class, 'viewNote'])->name('viewNote');


Route::get('/comment/{comment}/edit', [CommentController::class, 'edit'])->name('comment.edit');

// Route for updating a comment
Route::put('/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');

// Route for deleting a comment
Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
// For fetching notes by faculty, subject, and category

Route::get('/note/{noteId}/pdf-image', [NoteController::class, 'showPdfImage'])->name('note.pdf.image');
Route::post('/notes/{note}/toggle-favorite', [NoteController::class, 'toggleFavorite'])
    ->name('notes.toggleFavorite');
Route::get('/favorites', [NoteController::class, 'showFavorites'])->name('fav');
Route::delete('/del-favorites/{Favoriteid}', [NoteController::class, 'deleteFavorite'])->name('deleteFavorite');
Route::post('/SeeComments', [CommentController::class, 'store'])->name('comment.store');
Route::post('/StoreChat', [ChatController::class, 'store'])->name('chat.sendMessage');
Route::get('/fetchMessages', [ChatController::class, 'fetchMessages']);


Route::delete('/deleteMessage/{id}', [ChatController::class, 'deleteMessage'])->name('deleteMessage');


Route::group(['middleware' => ['auth', 'admin']], function () {
    // Route::get('/admin', function () {
    //     return view('admin.dashboard');
    // });
    Route::get('/admin', [AdminController::class, 'index'])->name('adminDash');
    Route::get('/email', [AdminController::class, 'getUser'])->name('emailUser');
    Route::get('/send_mail/{id}', [AdminController::class, 'sendMail']);
    Route::post('/send-email/{id}', [AdminController::class, 'sendEmail'])->name('send.email');


    Route::get('subject/associate-form', [SubjectController::class, 'showAssociateForm'])->name('associate-form');
    Route::post('subject/associate', [SubjectController::class, 'associateWithFaculty'])->name('associate');
    Route::get('association-table', [association::class, 'index'])->name('association');
    Route::delete('association-delete/{id}', [association::class, 'delete'])->name('deleteassociation');
  

});
Route::group(['middleware' => ['auth', 'moderator']], function () {
    // Route::get('/moderator', function () {
    //     return view('moderator.dashboard');
    // });
    Route::get('/moderator', [ModeratorController::class, 'moderatorDashboard'])
        ->name('moderator.dashboard');
    Route::get('/moderator/notes/{note}', [ModeratorController::class, 'reviewNote'])->name('reviewNote');
    Route::put('/moderator/notes/{note}', [ModeratorController::class, 'updateNote'])->name('updateNote');
    Route::get('/moderator/{moderatorId}/approvednotes', [ModeratorController::class, 'viewApprovedNotes'])->name('moderatorApprovedNotes');
    Route::get('/moderator/{moderatorId}/rejectednotes', [ModeratorController::class, 'viewRejectedNotes'])->name('moderatorRejectedNotes');
    Route::get('/moderator/{moderatorId}/pendingnotes', [ModeratorController::class, 'viewPendingNotes'])->name('moderatorPendingNotes');
  
}); Route::get('/moderator/{moderatorId}/UnderReviewnotes', [ModeratorController::class, 'viewUnderReviewNotes'])->name('moderatorUnderReviewNotes');
Route::get('/viewUser', [ModeratorController::class, 'index'])->name('viewUser');
Route::get('/editRole/{id}', [ModeratorController::class, 'edit'])->name('moderatorEdit');
Route::put('/updateRole/{id}', [ModeratorController::class, 'update'])->name('moderatorUpdate');
Route::get('/getSubjects/{faculty_id}', [ModeratorController::class, 'getSubjects']);
Route::get('/moderator/{moderatorId}/notes', [ModeratorController::class, 'viewNotes'])->name('moderatorViewNotes');

Route::get('/changePassword', [UserController::class, 'show'])->name('user.show');
Route::get('/UserProfile/{userId}', [UserController::class, 'edit'])->name('user.edit');
Route::put('/UpdateProfile/{userId}', [UserController::class, 'update'])->name('user.update');
Route::middleware('auth')->post('/password/update/{userId}', [UserController::class, 'updatePassword'])->name('Userpassword.update');

Route::post('/notifications/markAsRead', 'NotificationController@markAsRead')->name('notifications.markAsRead');
Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
Route::post('/payment/submit', [PaymentController::class, 'submitPayment'])->name('payment.submit');

Route::get('/payment/error', function () {
    return 'Payment error. Please try again later.'; // Or any other message you want to display
})->name('payment.error');
Route::post('/payment/store', [PaymentController::class, 'storePaymentData'])->name('payment.store');
Route::get('/confirmation', [PaymentController::class, 'confirmation'])->name('confirmation');
Route::get('/paymentcheck', [PaymentController::class, 'checkPayment'])->name('paymentcheck');
Route::get('/payment/detail', [PaymentController::class, 'paymentDetail'])->name('paymentDetail');
Route::get('User/payment/detail', [PaymentController::class, 'UserPaymentDetail'])->name('UserPaymentDetail');
// Routes
Route::get('/getFilteredNotes', [NoteController::class, 'getFilteredNotes']);

