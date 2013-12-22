CREATE TABLE "projects" (
    "project_id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "project_title" TEXT NOT NULL,
    "frameLength" INTEGER NOT NULL,
    "videoSourceURI" TEXT NOT NULL,
    "creationDate" TEXT NOT NULL
);
CREATE TABLE sqlite_sequence(name,seq);
CREATE TABLE "frames" (
    "frame_id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "frame_title" TEXT NOT NULL,
    "frame_bitmap" BLOB NOT NULL,
    "previousFrameGhosting" INTEGER NOT NULL,
    "showBgBitmap" INTEGER NOT NULL
);
