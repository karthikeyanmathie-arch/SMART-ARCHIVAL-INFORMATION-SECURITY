# User Guide

## Table of Contents
1. [Getting Started](#getting-started)
2. [User Registration and Login](#user-registration-and-login)
3. [Dashboard Overview](#dashboard-overview)
4. [Document Management](#document-management)
5. [Search Functionality](#search-functionality)
6. [Admin Features](#admin-features)
7. [Best Practices](#best-practices)

## Getting Started

The Smart Archival Information Security System is designed to help you manage, store, and retrieve organizational documents efficiently and securely.

### First Time Setup

1. **Register an Account**: Visit the registration page and create your account
2. **Login**: Use your credentials to access the system
3. **Explore the Dashboard**: Familiarize yourself with the interface
4. **Upload Documents**: Start adding your documents to the system

## User Registration and Login

### Registration

1. Navigate to the registration page (`/auth/register`)
2. Fill in the required information:
   - Username (unique identifier)
   - Email address
   - Password (use a strong password)
   - Confirm password
3. Click "Register"
4. You'll be redirected to the login page

### Login

1. Navigate to the login page (`/auth/login`)
2. Enter your username and password
3. Optionally check "Remember me" to stay logged in
4. Click "Login"

### Security Tips
- Use a unique, strong password
- Don't share your credentials
- Log out when using shared computers
- Change your password regularly

## Dashboard Overview

After logging in, you'll see your dashboard with:

### Statistics Cards
- **Total Documents**: Number of documents you've uploaded
- **Archived**: Number of archived documents
- **Active**: Number of active documents

### Recent Documents
A table showing your most recently uploaded documents with:
- Document title
- Category
- File type
- Upload date
- Quick action buttons (View, Download)

## Document Management

### Uploading Documents

1. Click "Upload" in the navigation menu
2. Fill in the upload form:
   - **File**: Select the document file
   - **Title**: Give your document a descriptive title
   - **Description**: Add details about the document (optional)
   - **Category**: Organize documents by category (e.g., "Reports", "Contracts")
   - **Tags**: Add comma-separated tags for easier searching
   - **Access Level**:
     - Private: Only you can access
     - Shared: Other users can view
     - Public: Anyone can view

3. Click "Upload Document"

**Supported File Types:**
- Documents: PDF, TXT, DOC, DOCX
- Spreadsheets: XLS, XLSX
- Images: JPG, JPEG, PNG, GIF

**Maximum File Size:** 16MB

### Viewing Documents

1. Click on any document title or use the "View" button
2. The document details page shows:
   - File information (name, type, size)
   - Category and tags
   - Access level and status
   - Upload and modification dates
   - Description (if provided)

### Editing Document Metadata

1. Open the document you want to edit
2. Click "Edit" button
3. Update the information:
   - Title
   - Description
   - Category
   - Tags
   - Access level
4. Click "Update Document"

**Note:** You can only edit metadata, not the file itself

### Downloading Documents

1. Open the document or find it in your list
2. Click "Download" button
3. The file will download with its original filename

### Archiving Documents

1. Open the document
2. Click "Archive" button
3. Archived documents are moved out of active view but remain accessible
4. Click "Unarchive" to restore

### Deleting Documents

1. Open the document
2. Click "Delete" button
3. Confirm the deletion
4. The file and all metadata will be permanently removed

**Warning:** Deletion is permanent and cannot be undone!

## Search Functionality

### Basic Search

1. Click "Search" in the navigation menu
2. Enter your search query
3. Click "Search"

The system searches across:
- Document titles
- Descriptions
- Tags
- Original filenames

### Advanced Search with Filters

In addition to text search, you can filter by:
- **Category**: Enter a specific category
- **File Type**: Filter by extension (e.g., "pdf", "docx")

### Search Results

Results show:
- Document title (clickable)
- Category
- File type
- Owner (who uploaded it)
- Upload date
- Action buttons (View, Download)

### Search Tips
- Use specific keywords for better results
- Combine text search with filters for precision
- Use tags effectively when uploading for easier searching
- Remember that private documents from other users won't appear in your results

## Admin Features

If you have administrator privileges, you'll see additional menu items:

### Admin Dashboard

Access at `/admin` to view:
- Total users in the system
- Total documents uploaded
- Recent activity logs

### User Management

Navigate to "Admin" → "Users" to:
- View all registered users
- See user roles and status
- Activate or deactivate user accounts
- View registration dates

**To activate/deactivate a user:**
1. Go to Users page
2. Find the user
3. Click the "Activate" or "Deactivate" button

**Note:** You cannot deactivate your own account

### Document Overview

Navigate to "Admin" → "Documents" to:
- View all documents in the system
- See document owners
- Access any document for review
- Monitor storage usage

### Audit Logs

Navigate to "Admin" → "Logs" to:
- View all system activities
- Track user actions
- Monitor security events
- Filter by date or user

Audit logs track:
- User logins and logouts
- Document uploads, views, downloads
- Document edits and deletions
- Administrative actions
- IP addresses for security

## Best Practices

### Document Organization

1. **Use Clear Titles**: Make document titles descriptive and searchable
2. **Add Descriptions**: Include relevant details for context
3. **Categorize Consistently**: Use a consistent set of categories
4. **Tag Effectively**: Add multiple relevant tags
5. **Review Regularly**: Archive or delete outdated documents

### Security

1. **Choose Appropriate Access Levels**:
   - Use "Private" for confidential documents
   - Use "Shared" for team documents
   - Use "Public" carefully for non-sensitive information

2. **Protect Sensitive Data**:
   - Don't upload highly confidential information without additional encryption
   - Review access levels periodically
   - Monitor audit logs for unusual activity

3. **Password Management**:
   - Use strong, unique passwords
   - Change passwords if you suspect compromise
   - Enable "Remember me" only on trusted devices

### Performance

1. **File Size**: Keep files under 16MB for optimal performance
2. **Bulk Operations**: Upload multiple files one at a time
3. **Regular Cleanup**: Archive or delete old documents
4. **Organized Storage**: Use categories and tags from the start

### Collaboration

1. **Share Wisely**: Set documents to "Shared" when appropriate
2. **Use Descriptions**: Help others understand document context
3. **Consistent Naming**: Adopt naming conventions with your team
4. **Regular Updates**: Keep document metadata current

## Keyboard Shortcuts

While in the application:
- **Tab**: Navigate between form fields
- **Enter**: Submit forms
- **Esc**: Close dialogs (in supported browsers)

## Mobile Usage

The system is responsive and works on mobile devices:
- Navigation menu adapts to smaller screens
- Forms are touch-friendly
- Tables scroll horizontally on narrow screens
- Upload works with device cameras

## Getting Help

If you need assistance:
1. Review this user guide
2. Check the README.md for technical details
3. Contact your system administrator
4. Report issues on GitHub

## Frequently Asked Questions

**Q: Can I edit an uploaded file?**
A: No, you can only edit the metadata. To change the file, delete it and upload a new version.

**Q: How long are documents stored?**
A: Documents are stored indefinitely until you delete them.

**Q: Can I recover deleted documents?**
A: No, deletion is permanent. Consider archiving instead if you're unsure.

**Q: What happens to my documents if my account is deactivated?**
A: Documents remain in the system but are not accessible until reactivation.

**Q: Can I download multiple documents at once?**
A: Currently, documents must be downloaded individually.

**Q: How do I change my password?**
A: Contact your administrator to reset your password.

**Q: What file types are supported?**
A: PDF, TXT, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG, GIF

**Q: Is there a file size limit?**
A: Yes, the maximum file size is 16MB per document.

---

For technical support or feature requests, please contact your system administrator or open an issue on GitHub.
